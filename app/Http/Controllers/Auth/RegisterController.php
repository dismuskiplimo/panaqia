<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');

        $this->initialize_options();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'          => 'required|string|max:255',
            'username'      => 'required|string|min:6|max:255|unique:users,username',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => 'required|string|min:6|confirmed',
            'country_code'  => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        //$host = 'https://ipinfo.io/';
        
        //$country = $_SERVER['REMOTE_ADDR'];
        
        //$country = '41.76.172.1';
        

        //$uri = $host . $country;

        //$details = json_decode(file_get_contents($uri));


        return User::create([
            'name'          => $data['name'],
            'username'      => $data['username'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'usertype'      => 'USER',
            //'country_code'  => $details->country,
            'country_code'  => $data['country_code'],
            'last_seen'     => Carbon::now(),
        ]);
    }

    protected function registered(Request $request, $user){
        if($this->_options->mail_enabled){
            $title = 'Welcome to ' . config('app.name');
            try{
                \Mail::send('emails.welcome', ['title' => $title, 'user' => $user], function ($message) use($user, $title){
                    $message->subject($title);
                    $message->to($user->email);
                });

            }catch(\Exception $e){
                Session::flash('error', $e->getMessage());
            }
        }
    }
}
