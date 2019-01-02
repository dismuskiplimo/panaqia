<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Illuminate\Support\Str;

use Session;

use Image;

use App\Card;

use App\Contact;

use App\ContactType;

use App\Membership;

use App\Award;

use App\Discussion;

use App\Hobby;

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

class ManagerController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    	$this->middleware('manager');
        
    	$this->initialize_options();
    }
}
