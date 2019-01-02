<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;

use App\EventRequest;

use App\EventCategory;

use App\AppNotification;

use App\User;

use App\Option;

use App\Discussion;

use App\EventLike;

use App\EventTag;

use App\Timezone;

use App\EventSocial;

use App\SocialLogo;

use Carbon\Carbon;

use Auth;

use Session;



class FrontController extends Controller
{
    public function __construct(){
        $this->initialize_options();
    }

    public function index(){
       
        $featured_events = Event::where('featured', 1)->where('featured_from', '>=', $this->_date)->where('featured_until','<=', $this->_date)->orderBy('created_at', 'desc')->get();

        return view('pages.index',[
    		'title' 	         => 'Home',
    		'nav'	             => 'home',
            'featured_events'    => $featured_events,
            'options'            => $this->_options,
    	]);
    }

    public function terms(){
        return view('pages.terms',[
            'title'              => 'Terms and Conditions',
            'nav'                => 'terms',
            'options'            => $this->_options,
        ]);
    }

    public function privacyPolicy(){
        return view('pages.privacy-policy',[
            'title'              => 'Privacy Policy',
            'nav'                => 'privacy-policy',
            'options'            => $this->_options,
        ]);
    }

    public function getAboutUs(){
    	return view('pages.about-us',[
    		'title' 	=> 'About Us',
    		'nav'	=> 'about-us',

    	]);
    }

    public function getContactUs(){
    	return view('pages.contact-us',[
    		'title' 	=> 'Contact Us',
    		'nav'	=> 'contact-us',

    	]);
    }

    public function searchEvent(Request $request, $tag = ''){
        if($request->has('search')){
            $this->validate($request, [
                'search' => 'max:255',
            ]);
        }

        $query = Event::query();

        if($request->has('search') && !empty($request->search)){
            $like_string = '%' . $request->search . '%';

            $query->where('name','LIKE',$like_string);
            $query->orWhere('venue','LIKE',$like_string);
            $query->orWhere('location','LIKE',$like_string);
            $query->orWhere('description','LIKE',$like_string);
            $query->orWhere('id',$request->search);
        }

        $events = $query->orderBy('created_at', 'DESC')->paginate($this->_pagination);

        return view('pages.search', [
            'title'     => 'Events',
            'nav'       => 'events',
            'events'    => $events,
            'request'   => $request,
            'today'     => $this->_date,
            'options'   => $this->_options,
        ]);
    }

    public function getTag($tag){
        $event_tags = EventTag::where('name', $tag)->orderBy('created_at', 'DESC')->paginate($this->_pagination);

        return view('pages.tags', [
            'title'         => 'Tags',
            'nav'           => 'events',
            'event_tags'    => $event_tags,
            'today'         => $this->_date,
            'tag'           => $tag,
            'options'       =>$this->_options,
        ]);
    }

    public function getEvent(Request $request, $slug = ''){
        $event  = Event::where('slug', $slug)->first();

        if(!$event){
            return view('errors.404');
        }

        $mine       = false;
        $user       = false;
        $logged_in  = false;
        $expired    = false;
        $previously_booked  =false;

        if($this->_date->gte($event->start_date)){
            $expired = true;
        }

        if(Auth::check()){
            $user = Auth::user();

            if($user->id == $event->user_id){
                $mine = true;
            }

            if($user->usertype == 'USER'){
                $logged_in = true;
            }

            $previously_booked = $event->requests()->where('from_id', $user->id)->first();
        }

        $speakers = $event->requests()->where('attending_as', 'SPEAKER')->where('approved', 1)->where('paid', 1)->get();
        $delegates = $event->requests()->where('attending_as', 'DELEGATE')->where('approved', 1)->where('paid', 1)->get();
        $exhibitors = $event->requests()->where('attending_as', 'EXHIBITOR')->where('approved', 1)->where('paid', 1)->get();

        $attendees = $event->requests()->where('approved', 1)->where('paid', 1)->get();

        $discussions = $event->discussions()->orderBy('created_at', 'ASC')->get();

        $event_categories = EventCategory::get();

        $timezones        = Timezone::orderBy('zone', 'ASC')->get();
        $icons            = SocialLogo::orderBy('name', 'ASC')->get();

        return view('pages.user.event',[
            'nav'           => 'events',
            'title'         => $event->name,
            'event'         => $event,
            'mine'          => $mine,
            'user'          => $user,
            'logged_in'     => $logged_in,
            'expired'       => $expired,
            'previously_booked' => $previously_booked,
            'event_categories'  => $event_categories,

            'speakers'      => $speakers,
            'delegates'     => $delegates,
            'exhibitors'    => $exhibitors,
            'discussions'   => $discussions,
            'attendees'     => $attendees,
            'timezones'     => $timezones,
            'icons'         => $icons,
            'today'         => $this->_date,
            'options'       =>$this->_options,
        ]);
    }

    public function attendEvent(Request $request, $slug){
        $this->validate($request, [
            'attending_as'  => 'required|max:255',
            'topic'         => 'max:255',
        ]);

        $event = Event::where('slug', $slug)->first();

        if(!$event){
            return view('errors.404');
        }

        $mine       = false;
        $user       = false;
        $logged_in  = false;
        $expired    = false;
        $previously_booked  =false;

        if($this->_date->gte($event->start_date)){
            $expired = true;
        }

        if(Auth::check()){
            $user = Auth::user();

            if($user->suspended){
                Session::flash('error', 'You cant book because your account has been suspended');
                return redirect()->route('event.view', ['slug'=> $event->slug]);
            }

            if($user->id == $event->user_id){
                $mine = true;
            }

            if($user->usertype == 'USER'){
                $logged_in = true;
            }

            $previously_booked = $event->requests()->where('from_id', $user->id)->first();
        }

        if($mine){
            Session::flash('error', 'You cant book your own event');
            return redirect()->route('event.view', ['slug'=> $event->slug]);
        }

        if($expired){
            Session::flash('error', 'The event can not be booked because it is past');
            return redirect()->route('event.view', ['slug'=> $event->slug]);
        }

        if($event->closed){
            Session::flash('error', 'The event can not be booked because it is closed');
            return redirect()->route('event.view', ['slug'=> $event->slug]);
        }

        if($previously_booked){
            Session::flash('error', 'You have already booked this event, please check your "BOOKED EVENTS" section');
            return redirect()->route('event.view', ['slug'=> $event->slug]);
        }

        if($request->attending_as == 'SPEAKER'){
            $price = 'speaker_price';
        }elseif($request->attending_as == 'DELEGATE'){
            $price = 'delegate_price';
        }elseif($request->attending_as == 'EXHIBITOR'){
            $price = 'exhibitor_price';
        }else{
            $price = 'delegate_price';
        }

        $price = $event->{$price};


        if($request->isMethod('post')){
            $event_request = new EventRequest;
            $event_request->from_id = $user->id;
            $event_request->event_id = $event->id;
            $event_request->attending_as = $request->attending_as;
            $event_request->code = generateRandomString(6);

            if($request->has('topic')){
                $event_request->topic = $request->topic;
            }

            if(!$event->invite_only){
                $event_request->approved = 1;
                $event_request->approved_at = $this->_date;
            }

            $event_request->amount_due = $price;

            $event_request->to_id = $event->user_id;
            
            $event_request->save();


            if($event->invite_only){
                $notification = new AppNotification;
                $notification->from_id = $user->id;
                $notification->to_id = $event->user_id;
                $notification->model_id = $event_request->id;
                $notification->notification_type = 'event.request.send';
                $notification->notification_status = 'success';
                $notification->message = 'you have a new event request from ';
                $notification->save();


                Session::flash('success', 'The Request has been sent, you  will receive notification once the request has been approved');

                return redirect()->route('event.view', ['slug' => $event->slug]);
            }else{
                if($price){
                    $event_request->paid = 0;
                    $event_request->update();

                    $notification = new AppNotification;
                    $notification->from_id = $user->id;
                    $notification->to_id = $event->user_id;
                    $notification->model_id = $event_request->id;
                    $notification->notification_type = 'event.interested';
                    $notification->notification_status = 'success';
                    $notification->message = 'your event was booked by ';
                    $notification->save();

                    Session::flash('success', 'Successfully Booked event, please checkout to complete the process');
                    return redirect()->route('user.checkout', ['id' => $event_request->id, 'type' => 'ticket']);
                }else{
                    $event_request->paid = 1;
                    $event_request->paid_at = $this->_date;
                    $event_request->amount_paid = $price;
                    $event_request->update();

                    $notification = new AppNotification;
                    $notification->from_id = $user->id;
                    $notification->to_id = $event->user_id;
                    $notification->model_id = $event_request->id;
                    $notification->notification_type = 'event.attending';
                    $notification->notification_status = 'success';
                    $notification->message = 'your event is being attended by ';
                    $notification->save();

                    Session::flash('success', 'Successfully Booked event, see you there :)');

                    ////////////////////////////////////////////////

                
                    if($this->_options->mail_enabled){
                        $pdf = loadTicket($event_request);
                        $event = $event_request->event;
                        $user = Auth::user();
                        $title = $event->name .  ' Event Ticket';
                        try{
                            \Mail::send('emails.ticket', ['title' => $title, 'user' => $user, 'event' => $event], function ($message) use($user, $title, $pdf, $event){
                                $message->subject($title);
                                $message->to($user->email);
                                $message->attachData($pdf->output(),  $event->name . ' ticket.pdf', ['mime' => 'application/pdf']);
                            });

                        }catch(\Exception $e){
                            //Session::flash('error', $e->getMessage());
                        }
                    }

                    /////////////////////////////////////////////////

                    return redirect()->route('event.view', ['slug' => $event->slug]);
                }

            }

        }

        if($request->attending_as == 'SPEAKER'){
            $attending = 'SPEAKER';
        }elseif($request->attending_as == 'DELEGATE'){
            $attending = 'DELEGATE';
        }else{
            $attending = 'SHOWCASER';
        }


        return view('pages.user.confirm-attendance', [
            'nav'           => 'event-confirm',
            'title'         => 'Confirm attendance',

            'event'         => $event,
            'mine'          => $mine,
            'user'          => $user,
            'logged_in'     => $logged_in,
            'expired'       => $expired,
            'attending_as'  => $request->attending_as,
            'attending'     => $attending,
            'price'         => $price,
        ]);
    }

    public function getProfile(Request $request, $username){
        $user = User::where('username',$username)->where('closed', 0)->first();

        if(!$user){
            return view('errors.404');
        }      

        $me         = false;
        $logged_in  = false;
        $request_sent = false;
        $request_approved = false;
        $has_requested_me = false;
        $has_been_approved = false;

        if(Auth::check()){
            $auth = Auth::user();
            if($auth->id == $user->id){
                $me = true;
            }

            if($user->usertype == 'USER'){
                $logged_in = true;
            }

            $request_sent = $auth->sent_requests()->where('to_id', $user->id)->where('approved', '0')->first();
            $request_approved = $auth->sent_requests()->where('to_id', $user->id)->where('approved', '1')->first();
            
            $has_requested_me = $user->sent_requests()->where('to_id', $auth->id)->where('approved', '0')->first();
            $has_ben_approved = $user->sent_requests()->where('to_id', $auth->id)->where('approved', '1')->first();

            if($user->id != Auth::user()->id){
                $user->views += 1;
                $user->update();
            }

        }else{
            $user->views += 1;
            $user->update();
        }


        $user_contacts = $user->contacts()->where('section', 'USER')->orderBy('created_at', 'desc')->get();
        $event_contacts = $user->contacts()->where('section', 'EVENT')->orderBy('created_at', 'desc')->get();
        $memberships = $user->memberships()->orderBy('created_at', 'desc')->get();
        $awards = $user->awards()->orderBy('created_at', 'desc')->get();
        $hobbies = $user->hobbies()->orderBy('created_at', 'desc')->get();
        $career_interests = $user->career_interests()->orderBy('created_at', 'desc')->get();

        $sent_requests = $user->sent_event_requests()->where('paid', 1)->where('approved', 1)->limit(4)->orderBy('created_at','DESC')->get();


        return view('pages.user.profile', [
            'nav'       => 'profile',
            'title'     => $user->name,
            'user'      => $user,
            'me'        => $me,
            'logged_in' => $logged_in,
            'today'     => $this->_date,

            'memberships'       => $memberships,
            'awards'            => $awards,
            'hobbies'           => $hobbies,
            'career_interests'  => $career_interests,
            'user_contacts'     => $user_contacts,
            'event_contacts'    => $event_contacts,
            'request_sent'      => $request_sent,
            'request_approved'      => $request_approved,
            'has_requested_me'      => $has_requested_me,
            'has_been_approved'      => $has_been_approved,
            'sent_requests'      => $sent_requests,
        ]);
    }

    public function getEventsAttending($username){
        $user= User::where('username', $username)->firstOrFail();

        $sent_requests = $user->sent_event_requests()->where('paid', 1)->where('approved', 1)->orderBy('created_at','DESC')->paginate($this->_pagination);

        return view('pages.user.events-attending',[
            'title'             => 'Events Attending',
            'nav'               => 'user.attending',
            'user'              => $user,
            'today'             => $this->_date,
            'sent_requests'     => $sent_requests,
        ]);
    }

    public function getSuspended(){
        if(auth()->check()){
            $user = auth()->user();

            if(!$user->suspended){
                return redirect()->route('dashboard');
            }else{
                if(!is_null($user->suspended_until)){
                    if($this->_date->gte($user->suspended_until)){
                        $user->suspended = 0;
                        $user->suspended_at = null;
                        $user->suspended_by = null;
                        $user->suspended_days = null;
                        $user->suspended_until = null;
                        $user->suspended_reason = null;
                        $user->save();

                        return redirect()->route('dashboard');
                    }
                }
            }
            
            return view('pages.user.suspended',[
                'title'             => 'Account Suspended',
                'nav'               => 'user.suspended',
                'user'              => auth()->user(),
                'today'             => $this->_date,
                
            ]);

        }else{
            return redirect()->route('login');
        }

        
    }

    public function login(Request $request){
        $this->validate($request, [
            'username' =>  'required|max:255',
            'password' =>  'required|max:255',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt(['email' => $request->username, 'password' => $request->password, 'closed' => 0], $remember) || Auth::attempt(['username' => $request->username, 'password' => $request->password, 'closed' => 0], $remember)) {
            Session::flash('success', 'Logged in successfully');
        }else{
            Session::flash('error', 'Credentials do not match our records');
        }

        return redirect()->back();
    }

    public function getAttendees($slug){
        $event = Event::where('slug', $slug)->first();

        $mine = false;

        if(auth()->check()){
            if(auth()->user()->id == $event->user_id){
                $mine = true;
            }
        }

        if(!$event){
            Session::flash('error', 'Event not found');
        }


        $paid_requests      = $event->requests()->where('paid', 1)->orderBy('created_at', 'DESC')->get();
        $paid_paypal        = $event->requests()->where('paid', 1)->where('payment_type','PAYPAL')->sum('amount_paid');
        $paid_mpesa         = $event->requests()->where('paid', 1)->where('payment_type','MPESA')->sum('amount_paid');
        $unpaid_requests    = $event->requests()->where('paid', 0)->orderBy('created_At', 'DESC')->get();

        return view('pages.user.attendees', [
            'nav'   => 'user.attendees',
            'title' => 'Attendees for ' . $event->name,
            'event' => $event,
            'paid_requests'         => $paid_requests,
            'paid_paypal'           => $paid_paypal,
            'paid_mpesa'            => $paid_mpesa,
            'unpaid_requests'       => $unpaid_requests,
            'options'               => $this->_options,
            'mine'                  => $mine,

        ]);
    }

    public function getDiscussion($slug){
        $event = Event::where('slug', $slug)->first();

        if(!$event){
            return response()->json(['status' => 404, 'message' => 'Event not found']);
        }

        $discussions = $event->discussions()->orderBy('created_at', 'ASC')->get();

        $discussion = [];

        foreach($discussions as $dis) {
            $discussion[] = [
                'name'      => $dis->user->name,
                'position'  => $dis->user->position ? : '',
                'avatar'    => profile_thumb($dis->user->thumbnail),
                'url'       => route('user.other-profile.view', ['username' => $dis->user->username]),
                'time'      => $dis->created_at->diffForHumans(),
                'message'   => $dis->message,
            ];
        }

        return response()->json(['status' => 200, 'count' => count($discussions), 'discussions' => $discussion]);
    }

    public function postDiscussion(Request $request, $slug){
        $event = Event::where('slug', $slug)->first();
        $user = Auth::user();

        if($user->suspended){
            return redirect()->route('suspended');
        }

        if(!$event){
            $message = 'Event not found';

            if($request->ajax()){
                return response()->json(['status' => 404, 'message' => $message]);
            }

            Session::flash('error', $message);
            return view('errors.404');
        }


        $this->validate($request,[
            'message' => 'required|max:400',
        ]);


        $discussion = new Discussion;
        $discussion->user_id = $user->id;
        $discussion->event_id = $event->id;
        $discussion->message = $request->message;
        $discussion->save();

        $message = 'Comment posted';

        if($request->ajax()){
            $data = [
                'name'      => $user->name,
                'position'  => $user->position ? : '',
                'avatar'    => profile_thumb($user->thumbnail),
                'url'       => route('user.other-profile.view', ['username' => $user->username]),
                'time'      => $discussion->created_at->diffForHumans(),
                'message'   => $discussion->message,
            ];
            return response()->json(['status' => 200, 'message' => $message, 'user' => $data]);
        }

        Session::flash('success', $message);

        return redirect()->back();
    }

    public function likeEvent(Request $request, $slug){
        $message = 'You need to be logged in to like this event';
        if(!Auth::check()){
            if($request->ajax()){
                $response = ['status' => 403, 'message' => $message];
                return response()->json($response);
            }

            Session::flash('error', $message);
            return redirect()->back();
        }

        $event = Event::where('slug', $slug)->first();

        if(!$event){
            $message = 'Event not found';

            if($request->ajax()){
                $response = ['status' => 404, 'message' => $message];
                return response()->json($response);
            }

            return view('errors.404');
        }

        $user = Auth::user();

        if($user->suspended){
            $message = 'Account Suspended';

            if($request->ajax()){
                $response = ['status' => 403, 'message' => $message];
                return response()->json($response);
            }

            return redirect()->route('suspended');
        }

        $event_like = $user->event_likes()->where('event_id', $event->id)->first();

        if($event_like){
            $event_like->forceDelete();

            $message = 'Event Unliked';

            if($request->ajax()){
                $response = ['status' => 200, 'message' => $message];
                    return response()->json($response);
            }

            Session::flash('success', $message);
            return redirect()->back();                                                                                                  
        }

        $event_like = new EventLike;
        $event_like->user_id = $user->id;
        $event_like->event_id = $event->id;
        $event_like->save();

        $message = 'Event Liked';

        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
                return response()->json($response);
        }

        Session::flash('success', $message);
        return redirect()->back();
    }
}
