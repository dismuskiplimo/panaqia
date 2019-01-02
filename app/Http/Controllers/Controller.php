<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Carbon\Carbon;

use App\Option;

use Config;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $_date,
    		  $_pagination = 18,
    		  $_public_path,
    		  $_image_path,
    		  $_storage_path,
              $_base_path,
    		  $_options;

    protected function initialize_options(){
    	$this->_date = Carbon::now();

    	$this->_public_path   = base_path(env('PUBLIC_PATH'));
		$this->_image_path    = base_path(env('PUBLIC_PATH') . '\img\uploads');
		$this->_storage_path  = storage_path('downloads\attachments');
		$this->_base_path     = base_path();
        

        $options = new \stdClass;

        $array = [];

        foreach (Option::get() as $option) {
            $options->{$option->name} = $option->value;

            $array[$option->name] = $option->value;
        }

        $options->array = $array;
        $options->today = $this->_date;

        $this->_options = $options;

        Config::set('mail.driver', $this->_options->mail_driver);
        Config::set('mail.host', $this->_options->mail_host);
        Config::set('mail.port', $this->_options->mail_port);
        Config::set('mail.from.address', $this->_options->mail_user_email);
        Config::set('mail.from.name', $this->_options->mail_user_name);
        Config::set('mail.encryption', $this->_options->mail_encryption);
        Config::set('mail.username', $this->_options->mail_username);
        Config::set('mail.password', $this->_options->mail_password);
        Config::set('services.sparkpost.secret', $this->_options->sparkpost_secret);
    }
}
