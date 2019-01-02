<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Illuminate\Support\Str;

use Session;

use Image;

use Hash;

use DB;

use App\Card;

use App\Contact;

use App\Currency;

use App\ContactType;

use App\Membership;

use App\Award;

use App\Discussion;

use App\Hobby;

use App\Country;

use App\Transaction;

use App\AppNotification;

use App\CareerInterest;

use App\Event;

use App\User;

use App\EventTag;

use App\CardRequest;

use App\Conversation;

use App\Message;

use App\MessageNotification;

use App\EventRequest;

use App\Option;

use Carbon\Carbon;

use App\Paypal_Transaction;

use App\MpesaTransaction;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    	$this->middleware('admin');
        
    	$this->initialize_options();
    }


    public function getDashboard(){
    	$today	= Carbon::today()->toDateString();

    	$start_of_month	= Carbon::now()->startOfMonth();
    	$end_of_month	= Carbon::now()->endOfMonth();

    	$start_of_year	= Carbon::now()->startOfYear();
    	$end_of_year	= Carbon::now()->endOfYear();

    	$months = [
    		'January',
    		'February',
    		'March',
    		'April',
    		'May',
    		'June',
    		'July',
    		'August',
    		'September',
    		'October',
    		'November',
    		'December',
    	];

    	$all_events_count	=	Event::count();
    	$all_events = Event::select(DB::raw('count(*) as total'),  DB::raw('YEAR(created_at) as year'))
             ->orderBy('year', 'DESC')
             ->groupBy('year')
             ->pluck('total','year')->all();

    	$events_today_count = Event::whereDate('created_at', '=', $today)->count();

        $events_this_month_count = Event::where('created_at', '>=', $start_of_month)->where('created_at', '<=', $end_of_month)->count();

    	$events_this_month = Event::select(DB::raw('count(*) as total'), DB::raw('DAY(created_at) as day'))
    		 ->where('created_at', '>=', $start_of_month)->where('created_at', '<=', $end_of_month)
             ->orderBy('day', 'ASC')
             ->groupBy('day')
             ->pluck('total','day')->all();

        $events_this_year_count = Event::where('created_at', '>=', $start_of_year)->where('created_at', '<=', $end_of_year)->count();

    	$events_this_year = Event::select(DB::raw('count(*) as total'), DB::raw('MONTH(created_at) as month'))
    		 ->where('created_at', '>=', $start_of_year)->where('created_at', '<=', $end_of_year)
             ->orderBy('month', 'ASC')
             ->groupBy('month')
             ->pluck('total','month')->all();


        $all_users_count	= User::where('usertype', 'USER')->count();
    	
    	$all_users  		= User::select(DB::raw('count(*) as total'),  DB::raw('YEAR(created_at) as year'))
    		 ->where('usertype', 'USER')
    		 ->orderBy('year', 'DESC')
             ->groupBy('year')
             ->pluck('total','year')->all();

    	$users_today_count = User::where('usertype', 'USER')->whereDate('created_at', '=', $today)->count();

        $users_this_month_count = User::where('usertype', 'USER')->where('created_at', '>=', $start_of_month)->where('created_at', '<=', $end_of_month)->count();

    	$users_this_month = User::select(DB::raw('count(*) as total'), DB::raw('DAY(created_at) as day'))
    		 ->where('usertype', 'USER')
    		 ->where('created_at', '>=', $start_of_month)->where('created_at', '<=', $end_of_month)
             ->orderBy('day', 'ASC')
             ->groupBy('day')
             ->pluck('total','day')->all();

        $users_this_year_count = User::where('usertype', 'USER')->where('created_at', '>=', $start_of_year)->where('created_at', '<=', $end_of_year)->count();

    	$users_this_year = User::select(DB::raw('count(*) as total'), DB::raw('MONTH(created_at) as month'))
    		 ->where('usertype', 'USER')
    		 ->where('created_at', '>=', $start_of_year)->where('created_at', '<=', $end_of_year)
             ->orderBy('month', 'ASC')
             ->groupBy('month')
             ->pluck('total','month')->all();    	

    	return view('pages.admin.index', [
    		'title' => 'Dashboard',
    		'nav'	=> 'dashboard',
    		'options'	=> $this->_options,
    		'events_today_count'		=> $events_today_count,
    		'all_events_count'			=> $all_events_count,
    		'all_events'				=> $all_events,
    		'events_this_month_count'	=> $events_this_month_count,
    		'events_this_month'			=> $events_this_month,
    		'events_this_year_count'	=> $events_this_year_count,
    		'events_this_year'			=> $events_this_year,

    		'users_today_count'			=> $users_today_count,
    		'all_users_count'			=> $all_users_count,
    		'all_users'					=> $all_users,
    		'users_this_month_count'	=> $users_this_month_count,
    		'users_this_month'			=> $users_this_month,
    		'users_this_year_count'		=> $users_this_year_count,
    		'users_this_year'			=> $users_this_year,

    		'days_in_month'				=> $start_of_month->daysInMonth,
    		'months'					=> $months,
    	]);
    }

    public function getTransactions(){
        $user = Auth::user();

        $transactions = Transaction::orderBy('created_at', 'DESC')->paginate($this->_pagination);

        return view('pages.admin.transactions', [
            'nav'           => 'all-transactions',
            'title'         => 'Transactions',
            'options'       => $this->_options,
            'today'         => $this->_date,
            'transactions'  => $transactions,


        ]);
    }

    public function getEvents(){
    	$auth = Auth::user();

    	$events = Event::orderBy('created_at', 'DESC')->paginate($this->_pagination);

    	return view('pages.admin.events', [
    		'nav'		=> 'all-events',
    		'title'		=> 'All Events',
    		'options'	=> $this->_options,
    		'today'		=> $this->_date,
    		'events'	=> $events,


    	]);
    }

    public function getActiveEvents(){
    	

    	$events = Event::where('start_date', '>=', defaultDate($this->_options->today))->where('closed', 0)->orderBy('created_at', 'DESC')->paginate($this->_pagination);

    	return view('pages.admin.events', [
    		'nav'		=> 'all-events',
    		'title'		=> 'Active Events',
    		'options'	=> $this->_options,
    		'today'		=> $this->_date,
    		'events'	=> $events,


    	]);
    }


    public function getPastEvents(){
    	

    	$events = Event::where('start_date', '<', defaultDate($this->_options->today))->orderBy('created_at', 'DESC')->paginate($this->_pagination);

    	return view('pages.admin.events', [
    		'nav'		=> 'all-events',
    		'title'		=> 'Past Events',
    		'options'	=> $this->_options,
    		'today'		=> $this->_date,
    		'events'	=> $events,


    	]);
    }

    public function getFeaturedEvents(){
    	

    	$events = $events = Event::where('start_date', '>=', defaultDate($this->_options->today))->where('featured', 1)->orderBy('created_at', 'DESC')->paginate($this->_pagination);

    	return view('pages.admin.events', [
    		'nav'		=> 'all-events',
    		'title'		=> 'Featured Events',
    		'options'	=> $this->_options,
    		'today'		=> $this->_date,
    		'events'	=> $events,


    	]);
    }

    public function getCancelledEvents(){
    	
    	$events = $events = Event::where('cancelled', 1)->orderBy('created_at', 'DESC')->paginate($this->_pagination);

    	return view('pages.admin.events', [
    		'nav'		=> 'all-events',
    		'title'		=> 'Cancelled Events',
    		'options'	=> $this->_options,
    		'today'		=> $this->_date,
    		'events'	=> $events,


    	]);
    }

    public function getClosedEvents(){
    	
    	$events = $events = Event::where('closed', 1)->orderBy('created_at', 'DESC')->paginate($this->_pagination);

    	return view('pages.admin.events', [
    		'nav'		=> 'closed-events',
    		'title'		=> 'Closed Events',
    		'options'	=> $this->_options,
    		'today'		=> $this->_date,
    		'events'	=> $events,


    	]);
    }

    public function getEvent($slug){
    	$event = Event::where('slug', $slug)->first();


    	if(!$event){
    		return view('pages.admin.errors.404', [
    			'nav' 	=> 'event',
    			'title'	=> 'Event not Found',
    		]);
    	}

    	$attendees = $event->requests()->where('approved', 1)->where('paid', 1)->count();

    	return view('pages.admin.event', [
    		'title' 	=> $event->name,
    		'nav'		=> 'view-event',
    		'options'	=> $this->_options,
    		'event'		=> $event,
    		'discussions'		=> $event->discussions()->orderBy('created_at', 'DESC')->get(),
    		'requests'			=> $event->requests()->where('approved', 0)->orderBy('created_at', 'DESC')->get(),
    		'attending'			=> $event->requests()->where('approved', 1)->where('paid', 1)->orderBy('created_at', 'DESC')->get(),
    		'unpaid'			=> $event->requests()->where('approved', 1)->where('paid', 0)->orderBy('created_at', 'DESC')->get(),
    		'attendees'			=> $attendees,
    	]);
    }

    public function getEventAttendees($slug){
    	$event = Event::where('slug', $slug)->first();


    	if(!$event){
    		return view('pages.admin.errors.404', [
    			'nav' 	=> 'event',
    			'title'	=> 'Event not Found',
    		]);
    	}

    	$attendees = $event->requests()->where('approved', 1)->where('paid', 1)->orderBy('created_at', 'DESC')->get();

    	return view('pages.admin.event-attendees', [
    		'title' 	=> $event->name . ' | Attendees',
    		'nav'		=> 'view-event-attendees',
    		'options'	=> $this->_options,
    		'event'		=> $event,
    		'attendees'			=> $attendees,
    	]);
    }

    public function getUserEventsAttended($username){
    	$user = User::where('username', $username)->first();


    	if(!$user){
    		return view('pages.admin.errors.404', [
    			'nav' 	=> 'user',
    			'title'	=> 'User not Found',
    		]);
    	}

    	$attendees = $user->sent_event_requests()->where('approved', 1)->where('paid', 1)->orderBy('created_at', 'DESC')->get();

    	return view('pages.admin.user-events', [
    		'title' 	=> 'Events Attended by ' . $user->name,
    		'nav'		=> 'view-event-attendees',
    		'options'	=> $this->_options,
    		
    		'attendees'			=> $attendees,
    	]);
    }

    public function closeEvent(Request $request, $slug){
    	$event = Event::where('slug', $slug)->first();

    	if(!$event){
    		return view('pages.admin.errors.404', [
    			'nav' 	=> 'event',
    			'title'	=> 'Event not Found',
    		]);
    	}

    	$event->closed = 1;
    	$event->closed_at = $this->_date;
    	$event->closed_by = Auth::user()->id;
    	$event->update();

    	Session::flash('success', 'Event Closed');

    	return redirect()->back();
    }

    public function withdrawEventCash(Request $request, $slug){
    	$this->validate($request, [
    		'picker_name'	=> 'required|max:255',
    		'picker_phone'	=> 'required|max:255',
    		'picker_id'		=> 'required|max:255',
    	]);

    	$event = Event::where('slug', $slug)->first();

    	if(!$event){
    		return view('pages.admin.errors.404', [
    			'nav' 	=> 'event',
    			'title'	=> 'Event not Found',
    		]);
    	}

    	$event->picker_name = $request->picker_name;
    	$event->picker_phone = $request->picker_phone;
    	$event->picker_id = $request->picker_id;
    	$event->withdrawn = 1;
    	$event->withdrawn_at = $this->_date;
    	$event->withdrawn_by = Auth::user()->id;
    	$event->update();
    	

    	Session::flash('success', 'Cash Withdrawn');

    	return redirect()->back();
    }

    public function getUser($username){
    	$auth = Auth::user();

    	$user = User::where('username', $username)->where('usertype', 'USER')->first();
    	
    	$countries = Country::orderBy('name', 'ASC')->get();
    	
    	$me = false;

    	if(!$user){
    		return view('pages.admin.errors.404', [
    			'nav' 	=> 'user',
    			'title'	=> 'User not Found',
    		]);
    	}

    	if($user->id == $auth->id){
    		$me = true;
    	}

    	return view('pages.admin.user', [
    		'nav'		=> 'view-user',
    		'title'		=> $user->name,
    		'user'		=> $user,
    		'options'	=> $this->_options,
    		'countries'	=> $countries,
    		'me'		=> $me,


    	]);
    }


    public function getUserEvents($username){
    	$auth = Auth::user();

    	$user = User::where('username', $username)->where('usertype', 'USER')->first();
    	
    	if(!$user){
    		return view('pages.admin.errors.404', [
    			'nav' 	=> 'user',
    			'title'	=> 'User not Found',
    		]);
    	}

    	return view('pages.admin.events', [
    		'nav'		=> 'events',
    		'title'		=> 'Events by ' . $user->name,
    		'user'		=> $user,
    		'options'	=> $this->_options,
    		'today'		=> $this->_date,
    		'events'	=> $user->events()->orderBy('created_at', 'DESC')->paginate($this->_pagination),


    	]);
    }


    public function getUsers(){
    	$users = User::where('usertype', 'USER')->where('suspended', 0)->orderBy('name', 'ASC')->paginate($this->_pagination);

    	return view('pages.admin.users', [
    		'title' 	=> 'Active Users',
    		'nav'		=> 'active-users',
    		'options'	=> $this->_options,
    		'users'		=> $users,
    	]);
    }

    public function getSuspendedUsers(){
    	$users = User::where('usertype', 'USER')->where('suspended', 1)->orderBy('name', 'ASC')->paginate($this->_pagination);

    	return view('pages.admin.users', [
    		'title' 	=> 'Suspended Users',
    		'nav'		=> 'suspended-users',
    		'options'	=> $this->_options,
    		'users'		=> $users,
    	]);
    }


    public function getSiteSettings(){
    	$currencies = Currency::orderBy('code', 'ASC')->get();

    	return view('pages.admin.site-settings', [
    		'title' => 'Site Settings',
    		'nav'	=> 'site-settings',
    		'options'	=> $this->_options,
    		'currencies' => $currencies,
    	]);
    }


    //Admins

    public function getAdmin($username){
    	$user = Auth::user();

    	$admin = User::where('username', $username)->where('is_admin', 1)->where('usertype', 'ADMIN')->first();
    	$countries = Country::orderBy('name', 'ASC')->get();
    	$me = false;

    	if(!$admin){
    		return view('pages.admin.errors.404', [
    			'nav' 	=> 'admin',
    			'title'	=> 'Admin',
    		]);
    	}

    	if($admin->id == $user->id){
    		$me = true;
    	}

    	return view('pages.admin.admin', [
    		'nav'		=> 'admin',
    		'title'		=> $admin->name,
    		'admin'		=> $admin,
    		'options'	=> $this->_options,
    		'countries'	=> $countries,
    		'me'		=> $me,


    	]);
    }

    public function getAdmins(){
    	$admins = User::where('is_admin', 1)->where('usertype', 'ADMIN')->orderBy('name', 'ASC')->paginate($this->_pagination);

    	return view('pages.admin.admins', [
    		'title' => 'Admins',
    		'nav'	=> 'admins',
    		'options'	=> $this->_options,
    		'admins' => $admins,
    	]);
    }


    public function createAdmin(){
  		$countries = Country::orderBy('name', 'ASC')->get();

    	return view('pages.admin.create-admin', [
    		'title' 	=> 'Create Admin',
    		'nav'		=> 'create-admin',
    		'options'	=> $this->_options,
    		'countries'	=> $countries,
    	]);
    }

    public function postCreateAdmin(Request $request){
    	$this->validate($request,[
    		'name'			=> 'required',
    		'username'		=> 'required|max:255|unique:users|min:6',
    		'email'			=> 'required|email|max:255|unique:users',
    		'country_code'	=> 'required',
    		'password'		=> 'required|confirmed|min:6',
    	]);

    	$user 				= new User;
    	$user->name 		= $request->name;
    	$user->username 	= $request->username;
    	$user->email 		= $request->email;
    	$user->country_code = $request->country_code;
    	$user->password 	= bcrypt($request->password);
    	$user->usertype 	= 'ADMIN';
    	$user->is_admin 	= 1;
    	$user->suspended 	= 0;
    	$user->last_seen 	= $this->_date;
    	$user->save();

    	Session::flash('success', 'Admin Added');

    	return redirect()->back();
    }

    public function getSettings(){
    	$countries = Country::orderBy('name', 'ASC')->get();
    	$user = Auth::user();
    	
    	return view('pages.admin.settings', [
    		'nav'			=> 'settings',
    		'title'			=> 'Account Settings',
    		'options'		=> $this->_options,
    		'countries'		=> $countries,
    		'admin'			=> $user,
    	]);
    }

    public function getAccount(){
        
        $user = Auth::user();
        
        return view('pages.admin.account', [
            'nav'           => 'account',
            'title'         => 'Account',
            'options'       => $this->_options,
            'user'          => $user,
        ]);
    }

    public function postUpdateAdmin(Request $request){
    	
    	$this->validate($request,[
    		'name'			=> 'required',
    		'username'		=> 'required|max:255|min:6',
    		'email'			=> 'required|email|max:255',
    		'country_code'	=> 'required',
    	]);

    	$user = Auth::user();

    	if($user->username != $request->username){
    		$r = User::where('username', $request->username)->first();
    		if(!$r){
    			$user->username 	= $request->username;
    		}else{
    			Session::flash('error', 'Username already taken');
    			return redirect()->back();
    		}
    	}

    	if($user->email != $request->email){
    		$r = User::where('email', $request->email)->first();
    		if(!$r){
    			$user->email 	= $request->email;
    		}else{
    			Session::flash('error', 'Email already taken');
    			return redirect()->back();
    		}
    	}

    	
    	$user->name 		= $request->name;
    	$user->country_code = $request->country_code;
    	$user->usertype 	= 'ADMIN';
    	$user->is_admin 	= 1;
    	$user->suspended 	= 0;
    	$user->last_seen 	= $this->_date;
    	$user->save();

    	Session::flash('success', 'Account Updated');

    	return redirect()->back();
    }

    public function postUpdatePassword(Request $request){
    	
    	$this->validate($request,[
    		'old_password'	=> 'required',
    		'password'	=> 'required|confirmed',
    	]);

    	$user = Auth::user();

    	if(Hash::check($request->old_password, $user->password)){
    		$user->password = bcrypt($request->password);
    		$user->save();

    		Session::flash('success', 'Password Updated');
    	}

    	else{
    		Session::flash('error', 'Password provided does not match the one in our database');
    	}

    	return redirect()->back();
    }

    public function suspendUser(Request $request, $username){
		$user = Auth::user();
    	$admin = User::where('username', $username)->first();

    	if(!$admin){
    		return view('pages.admin.404');
    	}

    	if($admin->id == $user->id){
    		Session::flash('error', 'Forbidden');
    		return redirect()->back();
    	}

    	$admin->suspended = 1;
    	$admin->suspended_by = $user->id;
    	$admin->suspended_at = $this->_date;
    	
    	$admin->activated_by = null;
    	$admin->activated_at = null;

    	$admin->update();

    	Session::flash('success', 'Suspended');
    	return redirect()->back();
    }

    public function activateUser(Request $request, $username){
    	$user = Auth::user();
    	$admin = User::where('username', $username)->first();

    	if(!$admin){
    		return view('pages.admin.404');
    	}

    	if($admin->id == $user->id){
    		Session::flash('error', 'Forbidden');
    		return redirect()->back();
    	}

    	$admin->suspended = 0;
    	$admin->suspended_by = null;
    	$admin->suspended_at = null;
    	
    	$admin->activated_by = $user->id;
    	$admin->activated_at = $this->_date;

    	$admin->update();

    	Session::flash('success', 'Activated');
    	return redirect()->back();
    }

    //Setttings


    public function postUpdateGeneralSettings(Request $request){
    	$this->validate($request, [
    		
            'currency'                => 'required',
            'paypal_currency'         => 'required',
            'exchange_rate'           => 'required|numeric|min:1',
    		'featured_price'	      => 'required|numeric|min:1',
    		'event_commission'	      => 'required|numeric|min:0|max:100',
    	]);

    	$fields = ['support_phone','support_email','currency', 'paypal_currency','paypal_email', 'event_commission', 'exchange_rate', 'featured_price'];

    	foreach ($fields as $field) {
    		$option = Option::where('name', $field)->firstOrFail();
    		$option->value = $request->{$field};
    		$option->update();
    	}

    	Session::flash('success', 'Settings Updated');

    	return redirect()->back();
    }

    public function postUpdateGateways(Request $request){
    	$this->validate($request, [
    		'paypal_client_id_sandbox'		=> 'required',
		   	'paypal_secret_sandbox'			=> 'required',
		   	'paypal_client_id_live'			=> 'required',
		   	'paypal_secret_live'			=> 'required',
		   	'paypal_mode'					=> 'required',

		   	'mpesa_consumer_key_sandbox'	=> 'required',
		   	'mpesa_consumer_secret_sandbox'	=> 'required',
		   	'mpesa_consumer_key_live'		=> 'required',
            'mpesa_consumer_secret_live'    => 'required',
            'mpesa_shortcode'               => 'required',
            'mpesa_passkey'                 => 'required',
		   	
		   	'mpesa_mode',
    	]);

    	$fields = [
    				'paypal_client_id_sandbox',
    			   	'paypal_secret_sandbox',
    			   	'paypal_client_id_live',
    			   	'paypal_secret_live',
    			   	'paypal_mode',

    			   	'mpesa_consumer_key_sandbox',
    			   	'mpesa_consumer_secret_sandbox',
    			   	'mpesa_consumer_key_live',
    			   	'mpesa_consumer_secret_live',
                    'mpesa_shortcode',
                    'mpesa_passkey',
                    'mpesa_callback_url',
    			   	'mpesa_mode',
    	];

    	foreach ($fields as $field) {
    		$option = Option::where('name', $field)->firstOrFail();
    		$option->value = $request->{$field};
    		$option->update();
    	}

    	Session::flash('success', 'Settings Updated');

    	return redirect()->back();
    }

    public function postUpdateEmailSettings(Request $request){
        $this->validate($request, [
            'mail_driver'               => 'required|max:255',
            'mail_enabled'              => 'required|max:255',
            'mail_host'                 => 'required|max:255',
            'mail_port'                 => 'required|numeric',
            'mail_username'             => 'required|max:255',
            'mail_password'             => 'required|max:255',
            'mail_encryption'           => 'required|max:255',
            'mail_user_name'            => 'required|max:255',
            'mail_user_email'           => 'required|max:255|email',
            
        ]);

        $fields = [
            'mail_driver',
            'mail_enabled',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_encryption',
            'sparkpost_secret',
            'mail_user_name',
            'mail_user_email',
        ];

        foreach ($fields as $field) {
            $option = Option::where('name', $field)->firstOrFail();
            
            if($field == 'mail_encryption'){
                if($request->{$field} == 'none'){
                    $option->value = null;
                }else{
                    $option->value = $request->{$field};
                }
            }else{
                $option->value = $request->{$field};
            }
            
            $option->update();
        }



        Session::flash('success', 'Email Settings Updated');
        return redirect()->back();
    }

    public function closeAccount(Request $request, $username){
        $this->validate($request, [
            'reason' => 'max:400',
        ]);

        $user = User::where('username', $username)->firstOrFail();

        $user->closed = 1;
        $user->closed_by = auth()->user()->id;
        $user->closed_at = $this->_date;
        $user->closed_reason = $request->reason;

        $user->update();

        Session::flash('success', 'Account closed');

        return redirect()->back();
    }

    public function reopenAccount(Request $request, $username){

        $user = User::where('username', $username)->firstOrFail();

        $user->closed = 0;
        $user->closed_by = null;
        $user->closed_at = null;
        $user->closed_reason = null;

        $user->update();

        Session::flash('success', 'Account Restored');

        return redirect()->back();
    }
}
