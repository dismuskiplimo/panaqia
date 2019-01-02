<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

use App\User;

class UserTableSeeder extends Seeder
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
        $users = [
        	[
        		'name'			=> 'Dismus Kiplimo',
        		'email'			=> 'dismuskiplimo@gmail.com',
        		'username'		=> 'dismuskiplimo',
        		'password'		=> bcrypt('lashizzle'),
        		'country_code'	=> 'KE',
        		'created_at'	=> $this->_date,
        		'updated_at'	=> $this->_date,
        		'last_seen'		=> $this->_date,
        		'usertype'		=> 'USER',
        	],

        	[
        		'name'			=> 'David Mangee',
        		'email'			=> 'david@gmail.com',
        		'username'		=> 'davido',
        		'password'		=> bcrypt('davido'),
        		'country_code'	=> 'KE',
        		'created_at'	=> $this->_date,
        		'updated_at'	=> $this->_date,
        		'last_seen'		=> $this->_date,
        		'usertype'		=> 'USER',
        	],
        ];

        $admins = [
            [
                'name'          => 'Admin',
                'email'         => 'admin@gmail.com',
                'username'      => 'admin',
                'password'      => bcrypt('administrator'),
                'country_code'  => 'KE',
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
                'last_seen'     => $this->_date,
                'usertype'      => 'ADMIN',
                'is_admin'      => 1,
            ],

            
        ];

        User::insert($users);
        User::insert($admins);
    }
}
