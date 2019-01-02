<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Option;

class OptionTableSeeder extends Seeder
{
	protected $_date;

    public function __construct(){
    	$this->_date = Carbon::now();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options = [
        	[
                'name'  => 'event_commission',
                'value' => '7',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'featured_price',
                'value' => '2000',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'account_balance_paypal',
                'value' => '0',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'to_be_payed_out_paypal',
                'value' => '0',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
        		'name'	=> 'profit_paypal',
        		'value'	=> '0',
        		'created_at'	=> $this->_date,
        		'updated_at'	=> $this->_date,
        	],

            [
                'name'  => 'account_balance_mpesa',
                'value' => '0',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'to_be_payed_out_mpesa',
                'value' => '0',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'profit_mpesa',
                'value' => '0',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'exchange_rate',
                'value' => '100',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],


        	[
        		'name'	=> 'support_phone',
        		'value'	=> '',
        		'created_at'	=> $this->_date,
        		'updated_at'	=> $this->_date,
        	],

        	[
        		'name'	=> 'currency',
        		'value'	=> 'KES',
        		'created_at'	=> $this->_date,
        		'updated_at'	=> $this->_date,
        	],

            [
                'name'  => 'paypal_currency',
                'value' => 'USD',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],


            [
                'name'  => 'support_email',
                'value' => '',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],


        	[
        		'name'	=> 'paypal_email',
        		'value'	=> '',
        		'created_at'	=> $this->_date,
        		'updated_at'	=> $this->_date,
        	],

        	[
        		'name'	=> 'paypal_client_id_sandbox',
        		'value'	=> 'ATM4R5bntlNfcLVJzc0TK2j4S-gK0YpoVnNn0H-zVA3wMulqe2Xck1Xh6Hi6dl_CHqzSe-Wx53PiV1qn',
        		'created_at'	=> $this->_date,
        		'updated_at'	=> $this->_date,
        	],

        	[
        		'name'	=> 'paypal_secret_sandbox',
        		'value'	=> 'EKlsxkJIkJxHqANjGZicCynqpoYz9wYQlJgNcZY4RYGUbmj9p0IMaRoBHhEfLYv03z3O-DgrMNP3OHj7',
        		'created_at'	=> $this->_date,
        		'updated_at'	=> $this->_date,
        	],

            [
                'name'  => 'paypal_client_id_live',
                'value' => 'AV1RG2EM6ES4OivSXurYxywLWIDl7VAt6-_SprgdqBdot6Ca15vJ3qAjduRoehLN73NGicX4dhGj9Bn3',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'paypal_secret_live',
                'value' => 'EIjcpWYpP_P83cxYJdhF-xnbHjAUtOGqrsiKVXSuv4FMuW6n1fwgHEMS0crDpVo7ADieO3CrM1nUJww-',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'paypal_mode',
                'value' => 'sandbox',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],


            [
                'name'  => 'mpesa_consumer_key_sandbox',
                'value' => 'dJ8z0skcGONvVa1w1NMbP531pxlGRxZA',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'mpesa_consumer_secret_sandbox',
                'value' => 'v4hzjn4X5afZoG3G',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'mpesa_consumer_key_live',
                'value' => 'nil',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'mpesa_consumer_secret_live',
                'value' => 'nil',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'mpesa_mode',
                'value' => 'sandbox',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'mpesa_shortcode',
                'value' => '174379',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'mpesa_passkey',
                'value' => 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'mpesa_callback_url',
                'value' => '',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],


            [
                'name'  => 'mail_enabled',
                'value' => '1',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'mail_driver',
                'value' => 'smtp',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'mail_host',
                'value' => 'smtp.mailtrap.io',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'mail_port',
                'value' => '2525',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'mail_username',
                'value' => '8de5a5d4bc4452',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'mail_password',
                'value' => '8ff486df91f583',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'mail_encryption',
                'value' => 'tls',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],


            [
                'name'  => 'mail_user_name',
                'value' => config('app.name'),
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'mail_user_email',
                'value' => 'dismuskiplimo@gmail.com',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],


            [
                'name'  => 'sparkpost_secret',
                'value' => '400b81f97a472a48fe8116543d948c341bb37146',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

        ];

        Option::insert($options);
    }
}
