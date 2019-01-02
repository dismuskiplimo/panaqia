<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use \PayPal\Rest\ApiContext;

use \PayPal\Auth\OAuthTokenCredential;

use \PayPal\Api\{Payer, Item, ItemList, Details, Amount, RedirectUrls, PaymentExecution};

use \PayPal\Api\Transaction as PaypalTransaction;

use \PayPal\Api\Payment as PaypalPayment;

use \PayPal\Service\AdaptiveAccountsService;

use \PayPal\Types\AA\{AccountIdentifierType, GetVerifiedStatusRequest};

use App\{Option,Currency, Event, EventRequest, AppNotification, AppLog, MpesaRequest, MpesaTransaction, Transaction, Paypal_Transaction};

use Auth, Config, Session;

class PaymentsController extends Controller
{
	protected $_paypal_client_id,
              $_paypal_secret,
              $_paypal_currency,
              $_paypal_mode,
              $_paypal_config,
              $_app_name,
              $_mpesa_consumer_key,
              $_mpesa_consumer_secret,
              $_mpesa_auth_url,
              $_mpesa_request_url,
              $_mpesa_query_url,
              $_mpesa_access_token;

    protected $_mpesa_errors = [
    	'0' => 'Success',
    	'1' => 'Insufficient Funds',
    	'2' => 'Less Than Minimum Transaction Value',
    	'3' => 'More Than Maximum Transaction Value',
    	'4' => 'Would Exceed Daily Transfer Limit',
    	'5' => 'Would Exceed Minimum Balance',
    	'6' => 'Unresolved Primary Party',
    	'7' => 'Unresolved Receiver Party',
    	'8' => 'Would Exceed Maxiumum Balance',
    	'11' => 'Debit Account Invalid',
    	'12' => 'Credit Account Invalid',
    	'13' => 'Unresolved Debit Account',
    	'14' => 'Unresolved Credit Account',
    	'15' => 'Duplicate Detected',
    	'17' => 'Internal Failure',
    	'20' => 'Unresolved Initiator',
    	'26' => 'Traffic blocking condition in place',
    ];

    public function __construct(){
    	

    	$this->initialize_options();

    	//paypal

    	$mode = $this->_options->paypal_mode;

        $this->_app_name = config('app.name');
        
        $this->_paypal_currency = $this->_options->paypal_currency;

        if($mode == 'sandbox'){
            $this->_paypal_client_id 	= $this->_options->paypal_client_id_sandbox;
            $this->_paypal_secret 		= $this->_options->paypal_secret_sandbox;
            $this->_paypal_mode 		= $mode;
        }elseif($mode == 'live'){
            $this->_paypal_client_id 	= $this->_options->paypal_client_id_live;
            $this->_paypal_secret 		= $this->_options->paypal_secret_live;
            $this->_paypal_mode 		= $mode;
        }else{
            $this->_paypal_mode = 'test';
        }

        $this->_paypal_config = [
            'mode' => $this->_paypal_mode,
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => '../PayPal.log',
            'log.LogLevel' => 'FINE',
            'validation.level' => 'log',
        ];


        $mode = $this->_options->mpesa_mode;
        
        if($mode == 'live'){
        	$this->_mpesa_consumer_key = $this->_options->mpesa_consumer_key_live;
        	$this->_mpesa_consumer_secret = $this->_options->mpesa_consumer_secret_live;
        	$this->_mpesa_auth_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        	$this->_mpesa_request_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        	$this->_mpesa_query_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
        }elseif($mode == 'sandbox'){
        	$this->_mpesa_consumer_key = $this->_options->mpesa_consumer_key_sandbox;
        	$this->_mpesa_consumer_secret = $this->_options->mpesa_consumer_secret_sandbox;
        	$this->_mpesa_auth_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        	$this->_mpesa_request_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        	$this->_mpesa_query_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
        }
    }

    public function makePaypalPayment(Request $request, $id, $type){
    	$user = auth()->user();

    	if($type == 'ticket'){
            $event_request = EventRequest::findOrFail($id);

            if(!$event_request){
                session()->flash('error', 'Event Request not found');
                return redirect()->back();
            }

            $event = $event_request->event;

            if(!$event){
                session()->flash('error', 'Event not found');
                return redirect()->back();
            }

            if($event->start_date->lte($this->_date)){
                session()->flash('error', 'This event has already passed');
                return redirect()->back();
            }

            
            if($event_request->paid){
                session()->flash('success', 'You have already paid for this Event');
                return redirect()->back();
            }

            $amount_to_pay = ceil($event_request->amount_due / $this->_options->exchange_rate);

            if($this->_paypal_mode == 'test'){

                $event_request->paid        = 1;
                $event_request->paid_at     = $this->_date;
                $event_request->amount_paid = $amount_to_pay;
                $event_request->amount_due -=  $amount_to_pay;
                $event_request->update();

                $transaction = new Transaction;
                $transaction->user_id = $user->id;
                $transaction->event_id = $event->id;
                $transaction->transaction_code = 'MXDDSDSW'; 
                $transaction->amount = $amount_to_pay;
                $transaction->medium = 'PAYPAL TEST';
                $transaction->status = 'COMPLETE';
                $transaction->description = 'Payment for ' . $event->name;
                $transaction->completed_at = $this->_date;
                $transaction->save();

                $notification                       = new AppNotification;
                $notification->to_id                = $event_request->to_id;
                $notification->from_id              = $event_request->from_id;
                $notification->model_id             = $event_request->id;
                $notification->notification_type    = 'request.balance.paid';
                $notification->notification_status  = 'success';
                $notification->message              = ucfirst('Payment received from ' . $event_request->user->id);
                $notification->save();

                session()->flash('success', $this->_options->currency . ' ' . number_format($amount_to_pay) . ' Has been received for ' . $event->name);

                return redirect()->back();
            }else{
                $credential = new OAuthTokenCredential($this->_paypal_client_id, $this->_paypal_secret);
                $paypal = new ApiContext($credential);
                
                $paypal->setConfig($this->_paypal_config);

                $payer = new Payer();
                $payer->setPaymentMethod('paypal');

                $item = new Item();
                $item->setName('Payment for the event ' . $event->name)
                     ->setCurrency($this->_paypal_currency)
                     ->setQuantity(1)
                     ->setPrice($amount_to_pay);

                $itemList = new ItemList();
                $itemList->setItems([$item]);

                $details = new Details();
                $details->setSubTotal($amount_to_pay);

                $amount = new Amount();
                $amount->setCurrency($this->_paypal_currency)
                       ->setTotal($amount_to_pay)
                       ->setDetails($details);

                $transaction = new PaypalTransaction();
                $transaction->setAmount($amount)
                            ->setItemList($itemList)
                            ->setDescription('Payment for the event ' . $event->name)
                            ->setInvoiceNumber(time());           

                $redirectUrls = new RedirectUrls();
                $redirectUrls->setReturnUrl(url(route('user.paypal.verify',['success'=>'true', 'amount' => $amount_to_pay, 'event_request' => $request->id, 'type' => $type ])))
                             ->setCancelUrl(url(route('user.paypal.verify',['success'=>'true', 'event_request' => $request->id, 'type' => $type])));

                $payment = new PaypalPayment();
                $payment->setIntent('sale')
                        ->setPayer($payer)
                        ->setRedirectUrls($redirectUrls)
                        ->setTransactions([$transaction]);


                try{
                    $payment->create($paypal);
                }catch(Exception $e){
                    $app_log = new AppLog;
                    $app_log->model_id = $event->id;
                    $app_log->message = $e;
                    $app_log->save();
                }

                $approvalUrl = $payment->getApprovalLink();

                return redirect($approvalUrl);
            }
        }

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////

        elseif($type == 'feature'){
            $event = Event::findOrFail($id);

            
            if($event->featured){
                session()->flash('success', 'You have already featured this Event');
                return redirect()->back();
            }

            $amount_to_pay = ceil($event->featured_amount / $this->_options->exchange_rate);

            if($this->_paypal_mode == 'test'){

                $event->featured                = 1;
                $event->featured_currency       = $this->_options->paypal_currency; 
                $event->update();

                $transaction                    = new Transaction;
                $transaction->user_id           = $user->id;
                $transaction->event_id          = $event->id;
                $transaction->transaction_code  = 'MXDDSDSW'; 
                $transaction->amount            = $amount_to_pay;
                $transaction->medium            = 'PAYPAL TEST';
                $transaction->status            = 'COMPLETE';
                $transaction->description       = 'Payment for Featuring ' . $event->name;
                $transaction->completed_at      = $this->_date;
                $transaction->save();

                session()->flash('success', $this->_options->currency . ' ' . number_format($amount_to_pay) . ' Has been received for Featuring ' . $event->name);

                return redirect()->back();
            }else{
                $credential = new OAuthTokenCredential($this->_paypal_client_id, $this->_paypal_secret);
                $paypal = new ApiContext($credential);
                
                $paypal->setConfig($this->_paypal_config);

                $payer = new Payer();
                $payer->setPaymentMethod('paypal');

                $item = new Item();
                $item->setName('Payment for the event ' . $event->name)
                     ->setCurrency($this->_paypal_currency)
                     ->setQuantity(1)
                     ->setPrice($amount_to_pay);

                $itemList = new ItemList();
                $itemList->setItems([$item]);

                $details = new Details();
                $details->setSubTotal($amount_to_pay);

                $amount = new Amount();
                $amount->setCurrency($this->_paypal_currency)
                       ->setTotal($amount_to_pay)
                       ->setDetails($details);

                $transaction = new PaypalTransaction();
                $transaction->setAmount($amount)
                            ->setItemList($itemList)
                            ->setDescription('Payment for the Featuring the event ' . $event->name)
                            ->setInvoiceNumber(time());           

                $redirectUrls = new RedirectUrls();
                $redirectUrls->setReturnUrl(url(route('user.paypal.verify',['success'=>'true', 'amount' => $amount_to_pay, 'event' => $event->id, 'type' => $type ])))
                             ->setCancelUrl(url(route('user.paypal.verify',['success'=>'true', 'event' => $event->id, 'type' => $type])));

                $payment = new PaypalPayment();
                $payment->setIntent('sale')
                        ->setPayer($payer)
                        ->setRedirectUrls($redirectUrls)
                        ->setTransactions([$transaction]);


                try{
                    $payment->create($paypal);
                }catch(Exception $e){
                    $app_log = new AppLog;
                    $app_log->model_id = $event->id;
                    $app_log->message = $e;
                    $app_log->save();
                }

                $approvalUrl = $payment->getApprovalLink();

                return redirect($approvalUrl);
            }
        }else{
            return redirect()->back();
        }
    }

    public function verifyPaypalPayment(Request $request, $type){
        
        $credential = new OAuthTokenCredential($this->_paypal_client_id,$this->_paypal_secret);
        $paypal = new ApiContext($credential);

        $paypal->setConfig($this->_paypal_config);
        
        $now = $this->_date;

        $user = auth()->user();

        
        if($type == 'ticket'){
            $event_request = EventRequest::findOrFail($request->event_request);
        
            $event = $event_request->event;

            if($request->has('success') && (bool)$request->success == true){
                if($request->has('paymentId') && $request->has('PayerID') && $request->has('token') && $request->has('amount') && $request->has('event_request')){

                    $success = (bool)$request->success;
                    $paymentId = $request->paymentId;
                    $payerId = $request->PayerID;
                    $token = $request->token;
                    $amount = (float)$request->amount;

                    $amount_to_pay = $amount;

                    $payment = PaypalPayment::get($paymentId, $paypal);
                    
                    $execute = new PaymentExecution();
                    $execute->setPayerId($payerId);

                    try{
                        $result = $payment->execute($execute, $paypal);
                    }catch(\PayPal\Exception\PayPalConnectionException $e){
                        $app_log = new AppLog;
                        $app_log->message = $e;
                        $app_log->save();

                        session()->flash('error','There was an error processing your payment, the token has already been used');
                        return redirect()->route('event.view', ['slug' => $event->slug]);
                    }

                    

                    $paypal_transaction = new PayPal_Transaction;
                    $paypal_transaction->user_id =$user->id;
                    $paypal_transaction->payment_id = $paymentId;
                    $paypal_transaction->payer_id = $payerId;
                    $paypal_transaction->token = $token;
                    $paypal_transaction->amount = $amount;
                    $paypal_transaction->event_request_id = $event_request->id;
                    $paypal_transaction->save();

                    $transaction = new Transaction;
                    $transaction->user_id = $user->id;
                    $transaction->event_id = $event->id;
                    $transaction->transaction_code = $token; 
                    $transaction->amount = $amount_to_pay;
                    $transaction->medium = 'PAYPAL';
                    $transaction->status = 'COMPLETE';
                    $transaction->description = 'Payment for ' . $event->name;
                    $transaction->completed_at = $this->_date;
                    $transaction->currency_code = $this->_options->paypal_currency;
                    $transaction->save();

                    $paypal_transaction->transaction_id = $transaction->id;
                    $paypal_transaction->update();


                    $event_request->paid            = 1;
                    $event_request->paid_at         = $this->_date;
                    $event_request->amount_paid     = $amount_to_pay;
                    $event_request->amount_due      = 0;
                    $event_request->payment_type    = 'PAYPAL';
                    $event_request->currency_code   = $this->_options->paypal_currency;
                    $event_request->update();

                    $account_balance_paypal = Option::where('name', 'account_balance_paypal')->firstOrFail();
                    $account_balance_paypal->value += $transaction->amount;
                    $account_balance_paypal->update();

                    $profit_paypal = Option::where('name', 'profit_paypal')->firstOrFail();
                    $profit_paypal->value += ($this->_options->event_commission / 100) * $transaction->amount;
                    $profit_paypal->update();

                    $to_be_payed_out_paypal = Option::where('name', 'to_be_payed_out_paypal')->firstOrFail();
                    $to_be_payed_out_paypal->value += ($transaction->amount) - ($this->_options->event_commission / 100) * $transaction->amount;
                    $to_be_payed_out_paypal->update();

                    $event_request->event->paypal_collected += $transaction->amount;
                    $event_request->event->paypal_commission += ($this->_options->event_commission / 100) * $transaction->amount;
                    $event_request->event->update(); 

                    $notification                       = new AppNotification;
                    $notification->to_id                = $event_request->to_id;
                    $notification->from_id              = $event_request->from_id;
                    $notification->model_id             = $event_request->id;
                    $notification->notification_type    = 'request.balance.paid';
                    $notification->notification_status  = 'success';
                    $notification->message              = ucfirst('Payment received from ' . $event_request->user->id);
                    $notification->save();

                    ////////////////////////////////////////////////

                
                    if($this->_options->mail_enabled){
                        $pdf = loadTicket($event_request);
                        $event = $event_request->event;
                        $user = auth()->user();
                        $title = $event->name .  ' Event Ticket';
                        try{
                            \Mail::send('emails.ticket', ['title' => $title, 'user' => $user, 'event' => $event], function ($message) use($user, $title, $pdf, $event){
                                $message->subject($title);
                                $message->to($user->email);
                                $message->attachData($pdf->output(),  $event->name . ' ticket.pdf', ['mime' => 'application/pdf']);
                            });

                        }catch(\Exception $e){
                            $app_log = new AppLog;
                            $app_log->message = $e;
                            $app_log->save();

                            //session()->flash('error', $e->getMessage());
                        }
                    }

                    /////////////////////////////////////////////////

                    session()->flash('success', $this->_options->paypal_currency . ' ' . number_format($amount_to_pay, 2) . ' Has been received for ' . $event->name);

                }else{
                    session()->flash('error','There was an error processing your payment, no money was deducted however');
                }
            }else{
                session()->flash('error','There was an error processing your payment, no money was deducted however');
            }

            return redirect()->route('event.view', ['slug' => $event->slug]);
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////////////

        elseif($type == 'feature'){
            $event = Event::findOrFail($request->event);
    

            if($request->has('success') && (bool)$request->success == true){
                if($request->has('paymentId') && $request->has('PayerID') && $request->has('token') && $request->has('amount') && $request->has('event')){

                    $success = (bool)$request->success;
                    $paymentId = $request->paymentId;
                    $payerId = $request->PayerID;
                    $token = $request->token;
                    $amount = (float)$request->amount;

                    $amount_to_pay = $amount;

                    $payment = PaypalPayment::get($paymentId, $paypal);
                    
                    $execute = new PaymentExecution();
                    $execute->setPayerId($payerId);

                    try{
                        $result = $payment->execute($execute, $paypal);
                    }catch(\PayPal\Exception\PayPalConnectionException $e){
                        $app_log = new AppLog;
                        $app_log->message = $e;
                        $app_log->save();

                        session()->flash('error','There was an error processing your payment, the token has already been used');
                        return redirect()->route('event.view', ['slug' => $event->slug]);
                    }

                    

                    $paypal_transaction = new PayPal_Transaction;
                    $paypal_transaction->user_id =$user->id;
                    $paypal_transaction->payment_id = $paymentId;
                    $paypal_transaction->payer_id = $payerId;
                    $paypal_transaction->token = $token;
                    $paypal_transaction->amount = $amount;
                    $paypal_transaction->event_request_id = null;
                    $paypal_transaction->save();

                    $transaction = new Transaction;
                    $transaction->user_id = $user->id;
                    $transaction->event_id = $event->id;
                    $transaction->transaction_code = $token; 
                    $transaction->amount = $amount_to_pay;
                    $transaction->medium = 'PAYPAL';
                    $transaction->status = 'COMPLETE';
                    $transaction->description = 'Payment for Featuring ' . $event->name;
                    $transaction->completed_at = $this->_date;
                    $transaction->currency_code = $this->_options->paypal_currency;
                    $transaction->save();

                    $paypal_transaction->transaction_id = $transaction->id;
                    $paypal_transaction->update();


                    $event->featured                = 1;
                    $event->featured_currency       = $this->_options->paypal_currency;
                    $event->update();

                    $account_balance_paypal = Option::where('name', 'account_balance_paypal')->firstOrFail();
                    $account_balance_paypal->value += $transaction->amount;
                    $account_balance_paypal->update();             


                    session()->flash('success', $this->_options->paypal_currency . ' ' . number_format($amount_to_pay, 2) . ' Has been received for Featuring ' . $event->name);

                }else{
                    session()->flash('error','There was an error processing your payment, no money was deducted however');
                }
            }else{
                session()->flash('error','There was an error processing your payment, no money was deducted however');
            }

            return redirect()->route('event.view', ['slug' => $event->slug]);
        }

        else{
            return redirect()->back();
        }
    }

    public function requestMpesaAccessToken(){
    	$url = $this->_mpesa_auth_url;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $credentials = base64_encode( $this->_mpesa_consumer_key . ':' . $this->_mpesa_consumer_secret);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        try {
        	list($header, $body) = explode("\r\n\r\n", $response, 2);

	        $fields = json_decode($body);
	        
	        $this->_mpesa_access_token = $fields->access_token;
        } catch (\Exception $e) {
        	$log = new AppLog;
        	$log->message = $e->getMessage();
        	$log->save();
        }
    }

    public function makeMpesaPayment(Request $request, $id, $type){
    	

    	$this->validate($request,[
    		'phone' => 'numeric|required',
    	]);

        if($type=="ticket"){
            $event_request = EventRequest::findOrFail($id);
            $event = $event_request->event;
            $description = 'Payment for ' . $event_request->event->name;
            $amount = $event_request->amount_due;
        }elseif($type=="feature") {
            $event = Event::findOrFail($id);
            $description = 'Payment for ' . $event->name;
            $amount = $event->featured_amount;
        }else{
            return redirect()->back();
        }

    	if($this->_options->mpesa_mode == 'sandbox'){
    		$amount = 1;
    	}else{
    		$amount = (int)ceil($amount);
    	}
    	
        $phone = $request->phone;

        $this->requestMpesaAccessToken();
        
        
        if($this->_mpesa_access_token){
            $url = $this->_mpesa_request_url;

            
            $shortcode = $this->_options->mpesa_shortcode;
            $passkey = $this->_options->mpesa_passkey;
            $timestamp = $this->_date->format('YmdHis');
            
            if($this->_options->mpesa_callback_url){
                $callback = $this->_options->mpesa_callback_url . route('user.mpesa.save', ['id' => $id, 'type' => $type], false);
            }else{
                $callback = url(route('user.mpesa.save', ['id' => $event->id, 'type' => $type]));
            }
            
            
            
            $password = base64_encode($shortcode.$passkey.$timestamp);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer ' . $this->_mpesa_access_token ));

            $curl_post_data = [
              'BusinessShortCode' => $shortcode,
              'Password' => $password,
              'Timestamp' => $timestamp,
              'TransactionType' => 'CustomerPayBillOnline',
              'Amount' => $amount,
              'PartyA' => $phone,
              'PartyB' => $shortcode,
              'PhoneNumber' => $phone,
              'CallBackURL' => $callback,
              'AccountReference' => 'panaqia',
              'TransactionDesc' => $description, 
            ];

            $data_string = json_encode($curl_post_data);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

            $curl_response = curl_exec($curl);

            $response = json_decode($curl_response);

            if(isset($response->errorCode) && !empty($response->errorCode)){
                session()->flash('error', $response->errorMessage);
                return redirect()->back();

                
            }else{
                if(isset($response->ResponseCode) && $response->ResponseCode == 0){
                    session()->flash('success', 'MPESA request received, please input your PIN and press Ok');
                
                    return redirect()->route('event.view', ['slug'=> $event->slug]);
                    
                }elseif(isset($response->ResponseCode) && $response->ResponseCode != 0){
                    session()->flash('error', $response->ResponseDescription);
                    return redirect()->back();
                }else{
                    return redirect()->back();
                }
                

            }
                
        }else{
            return redirect()->back();
        }
        

        /////////////////////////////////////////////////////////////////////////////////////////////
    }

    public function saveMpesaRequest(Request $request, $id, $type){
    	if($type == 'ticket'){
            $event_request = EventRequest::findOrFail($id);

            try {
                list($header, $body) = explode("\r\n\r\n", $request, 2);

                $fields = json_decode($body);

                $response = $fields->Body->stkCallback;  


                $mpesa_request                      = new MpesaRequest;
                $mpesa_request->user_id             = $event_request->from_id;  
                $mpesa_request->event_id            = $event_request->event_id; 
                
                $mpesa_request->MerchantRequestID   = $response->MerchantRequestID; 
                $mpesa_request->CheckoutRequestID   = $response->CheckoutRequestID; 
                $mpesa_request->ResultDesc          = $response->ResultDesc;    
                $mpesa_request->ResultCode          = $response->ResultCode;    
                $mpesa_request->save();     
                

                if($response->ResultCode == 0){

                    $items = $response->CallbackMetadata->Item;

                    $details = [];

                    foreach ($items as $item) {
                        $details[$item->Name] = isset($item->Value) ? $item->Value : null;
                    }

                    if($mpesa_request->ResultCode == 0){
                        $transaction                    = new Transaction;
                        $transaction->user_id           = $event_request->user->id;
                        $transaction->event_id          = $event_request->event->id;
                        $transaction->transaction_code  = $details['MpesaReceiptNumber'];
                        $transaction->amount            = (float)$details['Amount'];
                        $transaction->medium            = 'MPESA';
                        $transaction->status            = 'COMPLETE';
                        $transaction->completed_at      = $this->_date;
                        $transaction->currency_code     = $this->_options->currency;
                        $transaction->description       = 'Payment for ' . $event_request->event->name;
                        $transaction->save();

                        $mpesa_transaction                      = new MpesaTransaction;
                        $mpesa_transaction->Amount              = $details['Amount'];
                        $mpesa_transaction->MpesaReceiptNumber  = $details['MpesaReceiptNumber'];
                        $mpesa_transaction->Balance             = $details['Balance'];
                        $mpesa_transaction->TransactionDate     = $details['TransactionDate'];
                        $mpesa_transaction->PhoneNumber         = $details['PhoneNumber'];
                        $mpesa_transaction->user_id             = $event_request->user->id;
                        $mpesa_transaction->event_id            = $event_request->event->id;
                        $mpesa_transaction->mpesa_request_id    = $mpesa_request->id;
                        $mpesa_transaction->transaction_id      = $transaction->id;
                        $mpesa_transaction->save();

                        $event_request->amount_due  -= $transaction->amount;
                        $event_request->amount_paid += $transaction->amount;
                        
                        if($this->_options->mpesa_mode == 'sandbox'){
                            $event_request->paid = 1;
                            $event_request->paid_at = $this->_date;
                            $event_request->payment_type = 'MPESA';
                            $event_request->currency_code = $this->_options->currency;
                        }else{
                            if($event_request->amount_due <=0){
                                $event_request->paid = 1;
                                $event_request->paid_at = $this->_date;
                                $event_request->payment_type = 'MPESA';
                                $event_request->currency_code = $this->_options->currency;
                            }    
                        }
                        

                        $event_request->update();

                        $account_balance_mpesa = Option::where('name', 'account_balance_mpesa')->firstOrFail();
                        $account_balance_mpesa->value += $transaction->amount;
                        $account_balance_mpesa->update(); 

                        $profit_mpesa = Option::where('name', 'profit_mpesa')->firstOrFail();
                        $profit_mpesa->value += ($this->_options->event_commission / 100) * $transaction->amount;
                        $profit_mpesa->update();

                        $to_be_payed_out_mpesa = Option::where('name', 'to_be_payed_out_mpesa')->firstOrFail();
                        $to_be_payed_out_mpesa->value += ($transaction->amount) - ($this->_options->event_commission / 100) * $transaction->amount;
                        $to_be_payed_out_mpesa->update();

                        $event_request->event->mpesa_collected += $transaction->amount;
                        $event_request->event->mpesa_commission += ($this->_options->event_commission / 100) * $transaction->amount;
                        $event_request->event->update();

                        $message = 'MPESA ' . $this->_options->currency . ' '. number_format($transaction->amount) .' received from ' . $event_request->user->id;
                        
                        $notification                       = new AppNotification;
                        $notification->to_id                = null;
                        $notification->from_id              = $event_request->from_id;
                        $notification->model_id             = $event_request->id;
                        $notification->notification_type    = 'mpesa.received';
                        $notification->notification_status  = 'success';
                        $notification->message              = ucfirst($message);
                        $notification->save();

                        $message = 'MPESA ' . $this->_options->currency . ' '. number_format($transaction->amount) .' has been received ' . $event_request->user->id;

                        $notification                       = new AppNotification;
                        $notification->to_id                = $event_request->from_id;
                        $notification->from_id              = $event_request->to_id;
                        $notification->model_id             = $event_request->id;
                        $notification->notification_type    = 'mpesa.received';
                        $notification->notification_status  = 'success';
                        $notification->message              = ucfirst($message);
                        $notification->save();

                        ////////////////////////////////////////////////

                        if($this->_options->mail_enabled){
                            $pdf = loadTicket($event_request);
                            $event = $event_request->event;
                            $user = auth()->user();
                            $title = $event->name .  ' Event Ticket';
                            try{
                                \Mail::send('emails.ticket', ['title' => $title, 'user' => $user, 'event' => $event], function ($message) use($user, $title, $pdf, $event){
                                    $message->subject($title);
                                    $message->to($user->email);
                                    $message->attachData($pdf->output(),  $event->name . ' ticket.pdf', ['mime' => 'application/pdf']);
                                });

                            }catch(\Exception $e){
                                //session()->flash('error', $e->getMessage());
                            }
                        }

                        /////////////////////////////////////////////////
                    }   

                    
                }else{
                    $message = 'MPESA Payment not received for event ' . $event_request->event->name . '. Reason : ' . $response['ResultDesc'];

                    $notification                       = new AppNotification;
                    $notification->to_id                = $event_request->from_id;
                    $notification->from_id              = null;
                    $notification->model_id             = $event_request->id;
                    $notification->notification_type    = 'mpesa.not-received';
                    $notification->notification_status  = 'error';
                    $notification->message              = $message;
                    $notification->save();

                    $log = new AppLog;
                    $log->message = $message;
                    $log->save();
                }           
            } catch (\Exception $e) {
                $log = new AppLog;
                $log->message = $e->getMessage();
                $log->save();

                //echo $e->getMessage();
            }
        }


        ///////////////////////////////////////////////////////////////////////////////////////////////////

        elseif($type == 'feature'){
            $event = Event::findOrFail($id);

            try {
                list($header, $body) = explode("\r\n\r\n", $request, 2);

                $fields = json_decode($body);

                $response = $fields->Body->stkCallback;  


                $mpesa_request                      = new MpesaRequest;
                $mpesa_request->user_id             = $event->user->id;  
                $mpesa_request->event_id            = $event->id; 
                
                $mpesa_request->MerchantRequestID   = $response->MerchantRequestID; 
                $mpesa_request->CheckoutRequestID   = $response->CheckoutRequestID; 
                $mpesa_request->ResultDesc          = $response->ResultDesc;    
                $mpesa_request->ResultCode          = $response->ResultCode;    
                $mpesa_request->save();     
                

                if($response->ResultCode == 0){

                    $items = $response->CallbackMetadata->Item;

                    $details = [];

                    foreach ($items as $item) {
                        $details[$item->Name] = isset($item->Value) ? $item->Value : null;
                    }

                    if($mpesa_request->ResultCode == 0){
                        $transaction                    = new Transaction;
                        $transaction->user_id           = $event->user->id;
                        $transaction->event_id          = $event->id;
                        $transaction->transaction_code  = $details['MpesaReceiptNumber'];
                        $transaction->amount            = (float)$details['Amount'];
                        $transaction->medium            = 'MPESA';
                        $transaction->status            = 'COMPLETE';
                        $transaction->completed_at      = $this->_date;
                        $transaction->currency_code     = $this->_options->currency;
                        $transaction->description       = 'Payment for Featuring ' . $event->name;
                        $transaction->save();

                        $mpesa_transaction                      = new MpesaTransaction;
                        $mpesa_transaction->Amount              = $details['Amount'];
                        $mpesa_transaction->MpesaReceiptNumber  = $details['MpesaReceiptNumber'];
                        $mpesa_transaction->Balance             = $details['Balance'];
                        $mpesa_transaction->TransactionDate     = $details['TransactionDate'];
                        $mpesa_transaction->PhoneNumber         = $details['PhoneNumber'];
                        $mpesa_transaction->user_id             = $event->user->id;
                        $mpesa_transaction->event_id            = $event->id;
                        $mpesa_transaction->mpesa_request_id    = $mpesa_request->id;
                        $mpesa_transaction->transaction_id      = $transaction->id;
                        $mpesa_transaction->save();
                        
                        $event->featured = 1;
                        $event->featured_currency = $this->_options->currency;
                        $event->update();

                        $account_balance_mpesa = Option::where('name', 'account_balance_mpesa')->firstOrFail();
                        $account_balance_mpesa->value += $transaction->amount;
                        $account_balance_mpesa->update(); 

    

                        $notification                       = new AppNotification;
                        $notification->to_id                = null;
                        $notification->from_id              = $event->user->id;
                        $notification->model_id             = $event->id;
                        $notification->notification_type    = 'mpesa.received';
                        $notification->notification_status  = 'success';
                        $notification->message              = 'MPESA ' . $this->_options->currency . ' '. number_format($transaction->amount) .' received from ' . $event_request->user->id;
                        $notification->save();
                    }   

                    
                }else{
                    $message = 'MPESA Payment not received for featuring event ' . $event->name . '. Reason : ' . $response['ResultDesc'];

                    $notification                       = new AppNotification;
                    $notification->to_id                = $event->user->id;
                    $notification->from_id              = null;
                    $notification->model_id             = $event->id;
                    $notification->notification_type    = 'mpesa.not-received';
                    $notification->notification_status  = 'error';
                    $notification->message              = $message;
                    $notification->save();

                    $log = new AppLog;
                    $log->message = $message;
                    $log->save();
                }           
            } catch (\Exception $e) {
                $log = new AppLog;
                $log->message = $e->getMessage();
                $log->save();

                //echo $e->getMessage();
            }
        }else{
            return redirect()->back();
        } 	
    }
}
