<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\EventCategory;

class EventCategorySeeder extends Seeder
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
        $event_categories = [
        	[
                'name'  => 'Conference',
                'slug'  => str_slug('Conference'),
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'Forum',
                'slug'  => str_slug('Forum'),
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'Symposium',
                'slug'  => str_slug('Symposium'),
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'AGM',
                'slug'  => str_slug('AGM'),
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'Congress',
                'slug'  => str_slug('Congress'),
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'Seminar',
                'slug'  => str_slug('Seminar'),
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'Short Course',
                'slug'  => str_slug('Short Course'),
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'Networking Event',
                'slug'  => str_slug('Networking Event'),
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'Convention',
                'slug'  => str_slug('Convention'),
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'Dinner/Gala',
                'slug'  => str_slug('Dinner/Gala'),
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'Concert',
                'slug'  => str_slug('Concert'),
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'Training',
                'slug'  => str_slug('Training'),
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'Party',
                'slug'  => str_slug('Party'),
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'Expo ',
                'slug'  => str_slug('Expo'),
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],

            [
                'name'  => 'Other ',
                'slug'  => str_slug('Other'),
                'created_at'    => $this->_date,
                'updated_at'    => $this->_date,
            ],
								

        ];

        EventCategory::insert($event_categories);
    }
}
