<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

use App\ContactType;

class ContactTypeSeeder extends Seeder
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
        

        $contact_types = [
        	[
        		'name' => 'PHONE',
        		'created_at' => $this->_date,
        		'updated_at' => $this->_date,

        	],

        	[
        		'name' => 'MOBILE',
        		'created_at' => $this->_date,
        		'updated_at' => $this->_date,

        	],

        	[
        		'name' => 'EMAIL',
        		'created_at' => $this->_date,
        		'updated_at' => $this->_date,

        	],

        	[
        		'name' => 'WEBSITE',
        		'created_at' => $this->_date,
        		'updated_at' => $this->_date,

        	],

        	[
        		'name' => 'ADDRESS',
        		'created_at' => $this->_date,
        		'updated_at' => $this->_date,

        	],

        	[
        		'name' => 'FACEBOOK',
        		'created_at' => $this->_date,
        		'updated_at' => $this->_date,

        	],

        	[
        		'name' => 'TWITTER',
        		'created_at' => $this->_date,
        		'updated_at' => $this->_date,

        	],

        	[
        		'name' => 'LINKEDIN',
        		'created_at' => $this->_date,
        		'updated_at' => $this->_date,

        	],
        ];

        ContactType::insert($contact_types);
    }
}
