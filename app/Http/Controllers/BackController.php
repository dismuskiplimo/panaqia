<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use Auth;

use Session;

use Hash;

use App\Card;

use App\Option;

use Carbon\Carbon;

class BackController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
        
        $this->initialize_options();
    }

    public function getDashboard(){
    	$user = Auth::user();

    	if($user->is_admin()){
    		return redirect()->route('admin.dashboard');
    	}elseif($user->is_manager()){
    		return redirect()->route('manager.dashboard');
    	}elseif($user->is_user()){

            if(!$user->card){
                $card = new Card;
                $card->user_id = $user->id;
                $card->save();
            }

    		return redirect()->route('event.search');
    	}else{
    		return redirect()->route('home');
    	}
    }

    public function updatePassword(Request $request){
    	$this->validate($request,[
    		'old_password' => 'required|max:255',
    		'new_password' => 'required|max:255|confirmed',
    		'new_password_confirmation' => 'required|max:255',
    	]);

    	$user = User::find(Auth::user()->id);

    	if(!$user){
    		$message = 'User not found';

    		if($request->ajax()){
	  			$response = ['status' => '404', 'message' => $message];
	  			return response()->json($response);
	  		}

    		Session::flash('error', $message);
    		return redirect()->back();
    	}

    	if(Hash::check($request->old_password ,Auth::user()->password)){
    		$user->password = Hash::make($request->new_password);

            $user->update();

            $message = 'Password Updated';

            if($request->ajax()){
	  			$response = ['status' => '200', 'message' => $message];
	  			return response()->json($response);
	  		}

    		Session::flash('success', $message);
    	}else{
			$message = 'Old password does not match the password in our database';

			if($request->ajax()){
	  			$response = ['status' => '403', 'message' => $message];
	  			return response()->json($response);
	  		}

			Session::flash('error', $message);    		
    	}

    	return redirect()->back();
    }

    public function updateAccount(Request $request){
    	$this->validate($request,[
    		'name' => 'required|max:255',
    		'email' => 'required|email|max:255',
    		'username' => 'required|max:255',
            'country_code'  => 'max:255',
    	]);

    	$user = User::find(Auth::user()->id);

    	if(!$user){
    		$message = 'User not found';

    		if($request->ajax()){
	  			$response = ['status' => '404', 'message' => $message];
	  			return response()->json($response);
	  		}

    		Session::flash('error', $message);
    		return redirect()->back();
    	}

    	if($user->email != $request->email){
    		$email = User::where('email', $request->email)->first();

    		if(!$email){
    			$user->email = $request->email;
    		}else{
    			$message = 'That email is not available';

	    		if($request->ajax()){
		  			$response = ['status' => '400', 'message' => $message];
			  			return response()->json($response);
			  	}

		    	Session::flash('error', $message);
		    	return redirect()->back();
	    	}

    	}

    	if($user->username != $request->username){
    		$username = User::where('username', $request->username)->first();

    		if(!$username){
    			$user->username = $request->username;
    		}else{
    			$message = 'That username is not available';

	    		if($request->ajax()){
		  			$response = ['status' => '400', 'message' => $message];
			  			return response()->json($response);
			  	}

		    	Session::flash('error', $message);
		    	return redirect()->back();
	    	}	
    	}

        if($request->has('country_code')){
            $user->country_code = $request->country_code;
        }

  		$user->name = $request->name;

  		$user->update();

  		$message = 'Account Updated';
  		if($request->ajax()){
  			$response = ['status' => '200', 'message' => $message];
  			return response()->json($response);
  		}

  		Session::flash('success', $message);

  		return redirect()->back();
    }

    public function getMessageCount(){
        $user = Auth::user();

        $message_count = $user->message_notifications()->where('read', 0)->orderBy('created_at', 'DESC')->get();

        return response()->json(['status' => 200, 'count' => count($message_count)]);
    }

    public function getNotifications(){
        $user = Auth::user();

        $initial_notifications = $user->notifications()->where('read', 0)->orderBy('created_at', 'DESC')->get();
        
        $notifications = [];

        foreach ($initial_notifications as $r) {
            $notifications[] = [
                'sender_name' => $r->sender->name,
                'receiver_name' => $r->receiver->name,
                'avatar' => profile_thumb($r->sender->thumbnail),
                'message' => $r->message,
                'time' => $r->created_at->diffForHumans(),
            ];
        }

        return response()->json(['status' => 200, 'count' => count($initial_notifications), 'notifications' => $notifications]);
    }


    public function updateLastSeen(){
        $user = Auth::user();
        $user->last_seen = $this->_date;
        $user->update();
    }

}