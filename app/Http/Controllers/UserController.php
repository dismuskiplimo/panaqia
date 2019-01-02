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

use App\EventCategory;

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

use App\Timezone;

use App\EventSocial;

use App\SocialLogo;

use App\Education;

use App\Sponsor;

use App\Country;

use App\Reference;

use App\WorkExperience;

use App\Skill;

use Carbon\Carbon;



class UserController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('user');
        $this->middleware('not_closed');
    	$this->middleware('not_suspended');

        $this->initialize_options();	
    }

    public function getDashboard(){
    	return view('pages.user.index', [
    		'title' => 'Dashboard',
    		'nav' => 'user.dashboard',
    	]);
    }

    public function getSettings(){
    	$countries = Country::orderBy('name', 'ASC')->get();

        return view('pages.user.settings', [
    		'title' => 'Settings',
    		'nav' => 'user.settings',
            'countries' => $countries,
    	]);
    }

    public function getMyProfile(){
    	$user = Auth::user();
    	
    	$contact_types = ContactType::orderBy('name', 'ASC')->get(); 

    	$event_contacts = $user->contacts()->where('section', 'EVENT')->orderBy('created_at', 'desc')->get();
    	
    	$user_contacts = $user->contacts()->where('section', 'USER')->orderBy('created_at', 'desc')->get();

    	$memberships = $user->memberships()->orderBy('created_at', 'desc')->get();
    	$awards = $user->awards()->orderBy('created_at', 'desc')->get();
    	$hobbies = $user->hobbies()->orderBy('created_at', 'desc')->get();
    	$career_interests = $user->career_interests()->orderBy('created_at', 'desc')->get();

        $sent_requests = $user->sent_event_requests()->where('paid', 1)->where('approved', 1)->limit(4)->orderBy('created_at','DESC')->get();

    	return view('pages.user.my-profile', [
    		'title' 			=> 'Profile',
    		'nav' 				=> 'user.profile',
    		'user' 				=> $user,
    		'event_contacts'	=> $event_contacts,
    		'user_contacts'	=> $user_contacts,
            'contact_types'     => $contact_types,
    		'today'		        => $this->_date,

    		'memberships'		=> $memberships,
    		'awards'			=> $awards,
    		'hobbies'			=> $hobbies,
    		'career_interests'	=> $career_interests,
            'sent_requests'     => $sent_requests,
    	]);
    } 

    public function getCard(){
    	$user = Auth::user();
    	$card = Card::where('user_id', $user->id)->first();

    	if(!$card){
    		$card = new Card;
    		$card->user_id = $user->id;
    		$card->save();
    	}

        $card_requests = $user->card_requests()->where('approved', 0)->orderBy('created_at', 'desc')->get();
    	$card_requests_count = count($card_requests);
        $card_requests = $user->card_requests()->where('approved', 0)->orderBy('created_at', 'desc')->limit('10')->get();
    	
    	$approved_requests = $user->card_requests()->where('approved', 1)->orderBy('created_at', 'desc')->get();
        $approved_requests_count = count($approved_requests);
        $approved_requests = $user->card_requests()->where('approved', 1)->orderBy('created_at', 'desc')->limit('10')->get();

    	$contact_types = ContactType::orderBy('name', 'ASC')->get(); 
		$card_contacts = $user->contacts()->where('section', 'CARD')->orderBy('created_at', 'desc')->get();

		return view('pages.user.card', [
    		'title' 			=> 'Card',
    		'nav' 				=> 'user.card',
    		'user' 				=> $user,
    		'card'				=> $card,
            'card_requests'     => $card_requests,
    		'card_requests_count'		=> $card_requests_count,
            'approved_requests'         => $approved_requests,
    		'approved_requests_count'	=> $approved_requests_count,
    		'card_contacts'		=> $card_contacts,
    		'contact_types'		=> $contact_types,
    	]);
    }

    public function addContact(Request $request){
    	$this->validate($request,[
    		'section'	=> 'required|max:255',
    		'type'	=> 'required|max:255',
    		'contact'	=> 'required|max:255',
    	]);

    	$contact = new Contact;

    	$contact->section = $request->section;
    	$contact->type = $request->type;
    	$contact->contact = $request->contact;
    	$contact->user_id = Auth::user()->id;


    	if($request->section == 'CARD'){
    		$card = Card::find($request->card_id);
    		if($card){
    			$contact->card_id = $request->card_id;
    		}

    		else{
    			$message = "Card not found";
    	
		    	if($request->ajax()){
		    		$response = ['status' => 404, 'message' => $message];
		    		return response()->json($response);
		    	}

		    	Session::flash('error', $message);
		    	return redirect()->back();
    		}
    	}

    	$contact->save();

    	$message = "Contact added";
    	
    	if($request->ajax()){
    		$response = ['status' => 200, 'message' => $message];
    		return response()->json($response);
    	}

    	Session::flash('success', $message);
    	return redirect()->back();
    }

    public function addSocialLink(Request $request, $slug){
        $event = Event::where('slug', $slug)->first();

        if(!$event){
            Session::flash('error', 'Event not Found');

            return redirect()->back();
        }

        $this->validate($request,[
            'icon'  => 'required|max:255',
            'name'  => 'required|max:255',
            'link'  => 'required|max:255',
        ]);

        $link = new EventSocial;
        $link->icon = $request->icon;
        $link->name = $request->name;
        $link->link = $request->link;
        $link->event_id = $event->id;
        $link->save();

        Session::flash('success', 'Link Added');

        return redirect()->back();
    }

    public function deleteSocialLink(Request $request, $id){
    
        $link = EventSocial::findOrFail($id);

        $link->delete();

        $message = "Link Removed";
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        Session::flash('success', $message);
        return redirect()->back();
    }

    public function addEducation(Request $request){
        $this->validate($request,[
            'school'            => 'required|max:255',
            'level'             => 'required|max:255',
            'field_of_study'    => 'required|max:255',
            'grade'             => 'max:255',
            'start_year'        => 'required|max:255',
            'end_year'          => 'required|max:255',
        ]);

        $education = new Education;

        $education->school = $request->school;
        $education->level = $request->level;
        $education->field_of_study = $request->field_of_study;
        $education->grade = $request->grade;
        $education->start_year = $request->start_year;
        $education->end_year = $request->end_year;
        $education->user_id = Auth::user()->id;

        $education->save();

        $message = "Education added";
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        Session::flash('success', $message);
        return redirect()->back();
    }

    public function updateEducation(Request $request, $id){
        $this->validate($request,[
            'school'            => 'required|max:255',
            'level'             => 'required|max:255',
            'field_of_study'    => 'required|max:255',
            'grade'             => 'max:255',
            'start_year'        => 'required|max:255',
            'end_year'          => 'required|max:255',
        ]);

        $education = Education::findOrFail($id);

        if($education->user_id != Auth::user()->id){
            $message = "Forbidden";
        
            if($request->ajax()){
                $response = ['status' => 403, 'message' => $message];
                return response()->json($response);
            }

            Session::flash('error', $message);
            return redirect()->back();
        }

        $education->school = $request->school;
        $education->level = $request->level;
        $education->field_of_study = $request->field_of_study;
        $education->grade = $request->grade;
        $education->start_year = $request->start_year;
        $education->end_year = $request->end_year;
        $education->user_id = Auth::user()->id;

        $education->update();

        $message = "Education Updated";
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        Session::flash('success', $message);
        return redirect()->back();
    }

    public function deleteEducation(Request $request, $id){
    
        $education = Education::findOrFail($id);

        if($education->user_id != Auth::user()->id){
            $message = "Forbidden";
        
            if($request->ajax()){
                $response = ['status' => 403, 'message' => $message];
                return response()->json($response);
            }

            Session::flash('error', $message);
            return redirect()->back();
        }

        $education->delete();

        $message = "Education Removed";
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        Session::flash('success', $message);
        return redirect()->back();
    }

    public function deleteContact(Request $request, $id){
    	$contact = Contact::find($id);

    	if(!$contact){
    		$message = "Contact not found";
    	
	    	if($request->ajax()){
	    		$response = ['status' => 404, 'message' => $message];
	    		return response()->json($response);
	    	}

	    	Session::flash('error', $message);
	    	return redirect()->back();
    	}

    	$contact->delete();

    	$message = "Contact removed";
    	
    	if($request->ajax()){
    		$response = ['status' => 200, 'message' => $message];
    		return response()->json($response);
    	}

    	Session::flash('success', $message);
    	return redirect()->back();
    }

    public function updateCard(Request $request, $id){
    	$card = Card::find($id);

    	if(!$card){
    		$message = 'Card not found';

    		if($request->ajax()){
    			$response = ['status' => 404, 'message' => $message];
    			return response()->json($response);
    		}

    		Session::flash('error', $message);
    		return redirect()->back();
    	}

    	$this->validate($request, [
    		'description'	=> 'max:400',
    		'company'		=> 'required|max:255',
    		'position'		=> 'required|max:255',
    	]);

    	$card->company = $request->company;
    	$card->position = $request->position;
    	$card->description = $request->description;
    	$card->update();

    	
    	$message = 'Card updated';
    	
    	if($request->ajax()){
    		$response = ['status' => 200, 'message' => $message];
    		return response()->json($response);
    	}

    	Session::flash('success', $message);
    	return redirect()->back();
    }

    public function addMembership(Request $request){
    	
    	$this->validate($request, [
    		'name'	=> 'max:255|required',
    	]);

    	$membership = new Membership;
    	$membership->name = $request->name;
    	$membership->user_id = Auth::user()->id;
    	$membership->save();

    	$message = 'Membership Added';
    	
    	if($request->ajax()){
    		$response = ['status' => 200, 'message' => $message];
    		return response()->json($response);
    	}

    	Session::flash('success', $message);
    	return redirect()->back();
    }

    public function updateMembership(Request $request, $id){
        $membership = Membership::findOrFail($id);

        $user = Auth::user();

        if($membership->user_id != $user->id){
            Session::flash('error', 'Forbidden');

            return redirect()->back();
        }

        $this->validate($request, [
            'name'  => 'required|max:255',
        ]);

        $membership->name = $request->name;
        $membership->update();

        Session::flash('success', 'Membership Updated');

        return redirect()->back();
    }

    public function deleteMembership(Request $request, $id){
        $membership = Membership::findOrFail($id);

        $user = Auth::user();

        if($membership->user_id != $user->id){
            Session::flash('error', 'Forbidden');

            return redirect()->back();
        }

        $membership->delete();

        Session::flash('success', 'Membership Deleted');

        return redirect()->back();
    }

    public function addAward(Request $request){
    	
    	$this->validate($request, [
    		'name'	=> 'max:255|required',
    		'year'	=> 'min:1900|max:' . date('Y') . '|required|numeric',
    	]);

    	$award = new Award;
    	$award->name = $request->name;
    	$award->year = $request->year;
    	$award->user_id = Auth::user()->id;
    	$award->save();

    	$message = 'Award Added';
    	
    	if($request->ajax()){
    		$response = ['status' => 200, 'message' => $message];
    		return response()->json($response);
    	}

    	Session::flash('success', $message);
    	return redirect()->back();
    }

    public function updateAward(Request $request, $id){
        $award = Award::findOrFail($id);

        $user = Auth::user();

        if($award->user_id != $user->id){
            Session::flash('error', 'Forbidden');

            return redirect()->back();
        }

        $this->validate($request, [
            'name'  => 'required|max:255',
            'year'  => 'required|numeric|min:1900|max:' . date('Y'),
        ]);

        $award->name = $request->name;
        $award->year = $request->year;
        $award->update();

        Session::flash('success', 'Award Updated');

        return redirect()->back();
    }

    public function deleteAward(Request $request, $id){
        $award = Award::findOrFail($id);

        $user = Auth::user();

        if($award->user_id != $user->id){
            Session::flash('error', 'Forbidden');

            return redirect()->back();
        }

        $award->delete();

        Session::flash('success', 'Award Deleted');

        return redirect()->back();
    }

    public function addHobby(Request $request){
    	
    	$this->validate($request, [
    		'name'	=> 'max:255|required',
    	]);

    	$hobby = new Hobby;
    	$hobby->name = $request->name;
    	$hobby->user_id = Auth::user()->id;
    	$hobby->save();

    	$message = 'Hobby Added';
    	
    	if($request->ajax()){
    		$response = ['status' => 200, 'message' => $message];
    		return response()->json($response);
    	}

    	Session::flash('success', $message);
    	return redirect()->back();
    }

    public function updateHobby(Request $request, $id){
        $hobby = Hobby::findOrFail($id);

        $user = Auth::user();

        if($hobby->user_id != $user->id){
            Session::flash('error', 'Forbidden');

            return redirect()->back();
        }

        $this->validate($request, [
            'name'  => 'required|max:255',
        ]);

        $hobby->name = $request->name;
        $hobby->update();

        Session::flash('success', 'Hobby Updated');

        return redirect()->back();
    }

    public function deleteHobby(Request $request, $id){
        $hobby = Hobby::findOrFail($id);

        $user = Auth::user();

        if($hobby->user_id != $user->id){
            Session::flash('error', 'Forbidden');

            return redirect()->back();
        }

        $hobby->delete();

        Session::flash('success', 'Hobby Deleted');

        return redirect()->back();
    }

    public function addAchievement(Request $request){
    	
    	$this->validate($request, [
    		'name'	=> 'max:255|required',
    	]);

    	$career_interest = new CareerInterest;
    	$career_interest->name = $request->name;
    	$career_interest->user_id = Auth::user()->id;
    	$career_interest->save();

    	$message = 'Achievement Added';
    	
    	if($request->ajax()){
    		$response = ['status' => 200, 'message' => $message];
    		return response()->json($response);
    	}

    	Session::flash('success', $message);
    	return redirect()->back();
    }

    public function updateAchievement(Request $request, $id){
        $career_interest = CareerInterest::findOrFail($id);

        $user = Auth::user();

        if($career_interest->user_id != $user->id){
            Session::flash('error', 'Forbidden');

            return redirect()->back();
        }

        $this->validate($request, [
            'name'  => 'required|max:255',
        ]);

        $career_interest->name = $request->name;
        $career_interest->update();

        Session::flash('success', 'Achievement Updated');

        return redirect()->back();
    }

    public function deleteAchievement(Request $request, $id){
        $career_interest = CareerInterest::findOrFail($id);

        $user = Auth::user();

        if($career_interest->user_id != $user->id){
            Session::flash('error', 'Forbidden');

            return redirect()->back();
        }

        $career_interest->delete();

        Session::flash('success', 'Achievement Deleted');

        return redirect()->back();
    }

    public function addReference(Request $request){
        $this->validate($request,[
            'name'              => 'required|max:255',
            'phone'             => 'required|max:255',
            'email'             => 'max:255',
            'address'           => 'max:255',
            'company'           => 'max:255',
            'position'          => 'max:255',
        ]);

        $referee = new Reference;

        $referee->name      = $request->name;
        $referee->phone     = $request->phone;
        $referee->email     = $request->email;
        $referee->address   = $request->address;
        $referee->company   = $request->company;
        $referee->position  = $request->position;
        $referee->user_id   = Auth::user()->id;

        $referee->save();

        $message = "Reference added";
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        Session::flash('success', $message);
        return redirect()->back();
    }

    public function updateReference(Request $request, $id){
        $this->validate($request,[
            'name'              => 'required|max:255',
            'phone'             => 'required|max:255',
            'email'             => 'max:255',
            'address'           => 'max:255',
            'company'           => 'max:255',
            'position'          => 'max:255',
        ]);

        $referee = Reference::findOrFail($id);

        if($referee->user_id != Auth::user()->id){
            $message = "Forbidden";
        
            if($request->ajax()){
                $response = ['status' => 403, 'message' => $message];
                return response()->json($response);
            }

            Session::flash('error', $message);
            return redirect()->back();
        }

        $referee->name      = $request->name;
        $referee->phone     = $request->phone;
        $referee->email     = $request->email;
        $referee->address   = $request->address;
        $referee->company   = $request->company;
        $referee->position  = $request->position;

        $referee->update();

        $message = "Reference Updated";
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        Session::flash('success', $message);
        return redirect()->back();
    }

    public function deleteReference(Request $request, $id){
    
        $referee = Reference::findOrFail($id);

        if($referee->user_id != Auth::user()->id){
            $message = "Forbidden";
        
            if($request->ajax()){
                $response = ['status' => 403, 'message' => $message];
                return response()->json($response);
            }

            Session::flash('error', $message);
            return redirect()->back();
        }

        $referee->delete();

        $message = "Reference Removed";
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        Session::flash('success', $message);
        return redirect()->back();
    }

    public function addWorkExperience(Request $request){
        $this->validate($request,[
            'from'              => 'required|max:255',
            'to'                => 'required|max:255',
            'company'           => 'required|max:255',
            'position'          => 'required|max:255',
        ]);

        $work_experience = new WorkExperience;

        $work_experience->from_date      = $request->from;
        $work_experience->to_date        = $request->to;
        $work_experience->company   = $request->company;
        $work_experience->position  = $request->position;
        $work_experience->user_id   = Auth::user()->id;

        $work_experience->save();

        $message = "Work Experience added";
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        Session::flash('success', $message);
        return redirect()->back();
    }

    public function updateWorkExperience(Request $request, $id){
        $this->validate($request,[
            'from'              => 'required|max:255',
            'to'                => 'required|max:255',
            'company'           => 'required|max:255',
            'position'          => 'required|max:255',
        ]);

        $work_experience = WorkExperience::findOrFail($id);

        if($work_experience->user_id != Auth::user()->id){
            $message = "Forbidden";
        
            if($request->ajax()){
                $response = ['status' => 403, 'message' => $message];
                return response()->json($response);
            }

            Session::flash('error', $message);
            return redirect()->back();
        }

        $work_experience->from_date      = $request->from;
        $work_experience->to_date        = $request->to;
        $work_experience->company   = $request->company;
        $work_experience->position  = $request->position;

        $work_experience->update();

        $message = "Work Experience Updated";
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        Session::flash('success', $message);
        return redirect()->back();
    }

    public function deleteWorkExperience(Request $request, $id){
    
        $work_experience = WorkExperience::findOrFail($id);

        if($work_experience->user_id != Auth::user()->id){
            $message = "Forbidden";
        
            if($request->ajax()){
                $response = ['status' => 403, 'message' => $message];
                return response()->json($response);
            }

            Session::flash('error', $message);
            return redirect()->back();
        }

        $work_experience->delete();

        $message = "Work Experience Removed";
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        Session::flash('success', $message);
        return redirect()->back();
    }


    public function addSkill(Request $request){
        $this->validate($request,[
            'skill' => 'required|max:255',
        ]);

        $skill = new Skill;

        $skill->skill   = $request->skill;
        $skill->user_id = Auth::user()->id;

        $skill->save();

        $message = "Skill added";
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        Session::flash('success', $message);
        return redirect()->back();
    }

    public function updateSkill(Request $request, $id){
        $this->validate($request,[
            'skill' => 'required|max:255',
        ]);

        $skill = Skill::findOrFail($id);

        if($skill->user_id != Auth::user()->id){
            $message = "Forbidden";
        
            if($request->ajax()){
                $response = ['status' => 403, 'message' => $message];
                return response()->json($response);
            }

            Session::flash('error', $message);
            return redirect()->back();
        }

        $skill->skill = $request->skill;

        $skill->update();

        $message = "Skill Updated";
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        Session::flash('success', $message);
        return redirect()->back();
    }

    public function deleteSkill(Request $request, $id){
    
        $skill = Skill::findOrFail($id);

        if($skill->user_id != Auth::user()->id){
            $message = "Forbidden";
        
            if($request->ajax()){
                $response = ['status' => 403, 'message' => $message];
                return response()->json($response);
            }

            Session::flash('error', $message);
            return redirect()->back();
        }

        $skill->delete();

        $message = "Skill Removed";
        
        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        Session::flash('success', $message);
        return redirect()->back();
    }

    public function updateEventProfile(Request $request){
    	$user = Auth::user();

    	if(!$user){
    		$message = 'User not found';

    		if($request->ajax()){
    			$response = ['status' => 404, 'message' => $message];
    			return response()->json($response);
    		}
    	}

    	$this->validate($request, [
    		'name_of_company' | 'required|max:255',
    		'position' | 'required|max:255',
    		'sector' | 'max:255',
    	]);

    	$user->name_of_company = $request->name_of_company;
    	$user->position = $request->position;
    	$user->sector = $request->sector;
    	$user->update();

    	$message = 'Profile Updated';

    	if($request->ajax()){
    		$response = ['status' => 200, 'message' => $message];
    	}

    	Session::flash('success', $message);
    	return redirect()->back();
    }

    public function updateProfileBio(Request $request){
    	$user = Auth::user();

    	if(!$user){
    		$message = 'User not found';

    		if($request->ajax()){
    			$response = ['status' => 404, 'message' => $message];
    			return response()->json($response);
    		}
    	}
    		

    	$this->validate($request, [	
    		'bio' | 'max:800',
    	]);

    	$user->bio = $request->bio;
    	$user->update();

    	$message = 'Info Updated';

    	if($request->ajax()){
    		$response = ['status' => 200, 'message' => $message];
    	}

    	Session::flash('success', $message);
    	return redirect()->back();
    }

    public function getCreateEvent(){
        $event_categories = EventCategory::get();
    	$timezones        = Timezone::orderBy('zone', 'ASC')->get();

        return view('pages.user.create-event', [
    		'title'               => 'Create Event',
    		'nav'                 => 'user.create-event',
            'options'             => $this->_options,
            'event_categories'    => $event_categories,
            'timezones'           => $timezones,
    	]);
    }

    public function postCreateEvent(Request $request){
    	$this->validate($request,[
    		'name' 			=> 'required|max:255',
    		'start_date' 	=> 'required|date_format:Y-m-d',
    		'end_date' 		=> 'required|date_format:Y-m-d',
    		'start_time' 	=> 'required|max:5',
    		'end_time' 		=> 'required|max:5',
    		'description' 	=> 'required',
            'venue'         => 'required|max:255',
            'event_category_id'     => 'required|min:1|numeric',
            'timezone_id'     => 'required|min:1|numeric',
    		
    		'payment_method' 		=> 'required|max:255',
    		'speaker_price' 		=> 'min:0|numeric',
    		'delegate_price' 		=> 'min:0|numeric',
    		'exhibitor_price' 		=> 'min:0|numeric',
    		'banner'				=> 'min:0.001|max:40960|mimes:jpeg,jpg,png,tiff'
    	]);

        $bannerName     = null;
        $thumbName      = null;
    	$featuredName   = null;

    	if($request->hasFile('banner')){
    		
  
            try{
                $rand       = rand(1,100000);

                $file         = $request->file('banner');

                $ext = $file->getClientOriginalExtension();

                $bannerName     = 'banner_'. time() . $rand . '.' . $ext;
                $featuredName   = 'featured_'. time() . $rand . '.' . $ext;
                $thumbName      = 'thumbnail_'. time() . $rand . '.' . $ext;
                
                $image_path     = $this->_image_path . '\\' . $bannerName;
                $featured_path  = $this->_image_path . '\\featured_images\\' . $featuredName;
                $thumb_path     = $this->_image_path . '\\thumbnails\\' . $thumbName;
                
                Image::make($file)->orientate()->resize(1024,null, function($constraint){
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($image_path);

                Image::make($file)->orientate()->fit(1920, 950)->save($featured_path);
                
                Image::make($file)->orientate()->fit(400, 225)->save($thumb_path);
            }catch(\Exception $e){
                Session::flash('error', 'Event Banner not uploaded. Reason: ' . $e->getMessage());
                return redirect()->back();
            }
            
    	}



    	$event = new Event;
    	$event->name 		= $request->name;
    	$event->slug 		= Str::slug($request->name) . '-' . rand(1,10000);
    	$event->start_date 	= $request->start_date;
    	$event->end_date 	= $request->end_date;
    	$event->start_time 	= $request->start_time;
    	$event->end_time 	= $request->end_time;
        $event->description = $request->description;
        $event->category_id = $request->event_category_id;
        $event->timezone_id = $request->timezone_id;
    	$event->venue 		= $request->venue;
    	$event->map 		= $request->map;
        $event->banner              = $bannerName;
        $event->thumbnail           = $thumbName;
    	$event->featured_image 		= $featuredName;
    	
    	$event->speaker_price 		= $request->speaker_price;
    	$event->delegate_price 		= $request->delegate_price;
    	$event->exhibitor_price 	= $request->exhibitor_price;
    	$event->payment_method 		= $request->payment_method;
        $event->commission_percent  = $this->_options->event_commission;

        $zone = $event->timezone->zone;

        

        $crb = new Carbon($zone);

        $event->tz = $crb->format('P');

    	$event->invite_only	= $request->restriction;

    	if($request->has('include_weekends')){
    		$event->include_weekends = 1;
    	}

    	if($request->has('collect_revenue')){
    		$event->collect_revenue = 1;
    	}

    	if($request->has('promote_event')){
    		$event->promote_event = 1;
    	}

    	if($request->has('manage_attendees')){
    		$event->manage_attendees = 1;
    	}

    	$event->user_id = Auth::user()->id;

    	$event->save();

    	$message = "Event Added";

    	if($request->ajax()){
    		$response = ['status' => 200, 'message' => $message];

    		return response()->json($response);
    	}

    	Session::flash('success', $message);

    	return redirect()->route('event.view',['slug'=> $event->slug]);
    }

    public function updateEvent(Request $request, $slug){
        $event  = Event::where('slug', $slug)->first();
        $user   = Auth::user(); 

        if(!$event){
            return view('errors.404');
        }

        if($event->user_id != $user->id){
            Session::flash('error',  'Forbidden');
            return redirect()->back();
        }

        if($event->closed){
            Session::flash('error',  'Event Closed, no more editing');
            return redirect()->back();
        }

        $this->validate($request, [

            'name'          => 'required|max:255',
            'start_date'    => 'required|date_format:Y-m-d',
            'end_date'      => 'required|date_format:Y-m-d',
            'start_time'    => 'required|max:5',
            'end_time'      => 'required|max:5',
            'description'   => 'required',
            'venue'         => 'required|max:255',
            'event_category_id'     => 'required|min:1|numeric',
            'timezone_id'           => 'required|min:1|numeric',
        
            'speaker_price'         => 'min:0|numeric',
            'delegate_price'        => 'min:0|numeric',
            'exhibitor_price'       => 'min:0|numeric',
        ]);


        $event->name                = $request->name;
        $event->start_date          = $request->start_date;
        $event->end_date            = $request->end_date;
        $event->start_time          = $request->start_time;
        $event->end_time            = $request->end_time;
        $event->description         = $request->description;
        $event->category_id         = $request->event_category_id;
        $event->timezone_id         = $request->timezone_id;
        $event->venue               = $request->venue;
        $event->speaker_price       = $request->speaker_price;
        $event->delegate_price      = $request->delegate_price;
        $event->exhibitor_price     = $request->exhibitor_price;
        $event->invite_only         = $request->restriction;
        $event->map                 = $request->map;

        $zone = $event->timezone->zone;

        $crb = new Carbon($zone);

        $event->tz = $crb->format('P');

        if($request->has('include_weekends')){
            $event->include_weekends = 1;
        }

        $event->update();

        Session::flash('success', 'Event Updated');

        return redirect()->back();
    }

    public function featureEvent(Request $request, $slug){
        $this->validate($request, [
            'featured_from' => 'required',
            'days'          => 'required|numeric|min:1',
        ]);

        $event = Event::where('slug', $slug)->firstOrFail();

        if($event->featured){
            Session::flash('error', 'Event already featured');

            return redirect()->back();
        }

       
        $event->featured_from   = $request->featured_from;
        $event->featured_until  = $event->featured_from->addDays($request->days);
        $event->featured_days   = $request->days;
        $event->featured_amount = $request->days * $this->_options->featured_price;
        $event->update();

        return redirect()->route('user.feature-process', ['slug' => $event->slug]); 
    }

    public function processFeaturedEvent(Request $request, $slug){
        $user = Auth::user();

        $event = Event::where('slug', $slug)->firstOrFail();

        if($request->has('payment_method')){
            if($request->payment_method == 'mpesa'){
                return view('pages.user.mpesa-checkout-featured', [
                    'nav'   => 'mpesa-checkout',
                    'title' => 'Mpesa Checkout',
                    'user'  =>  $user,
                    'event' => $event,
                    'options' => $this->_options,
                ]);


            }elseif($request->payment_method == 'cc'){
                return redirect()->route('user.paypal.request',['id'=>$event->id, 'type' => 'feature']);
            }
        }

        return view('pages.user.select-payment-method', [
            'nav'   => 'payment-method',
            'title' => 'Select Payment Method',
            'user'  =>  $user,
            'event' => $event,
            'options' => $this->_options,
        ]);
    }

    public function eventCheckout(Request $request, $id = '', $type = 'ticket'){
        $event_request = EventRequest::find($id);
        $user = Auth::user();

        if(!$event_request){
            Session::flash('error', 'Event Request Not found');
            return redirect()->back();
        }

        $event = $event_request->event;

        if(!$event){
            Session::flash('error', 'Event Not found');
            return redirect()->back();
        }

        if($user->id != $event_request->from_id){
            Session::flash('error', 'Forbidden');
            return redirect()->back();   
        }

        if($event->start_date->gte($this->_date)){

            return $this->getPaymentMethod($event_request, $request, $type);
            
        }else{
            Session::flash('error', 'The event start date is already past');
            return redirect()->route('event.view', ['slug'=>$event->slug]);
        }
    }

    public function getPaymentMethod(EventRequest $event_request, Request $request, $type = 'ticket'){
        $user = Auth::user();

        if($request->has('payment_method')){
            if($request->payment_method == 'mpesa'){
                return view('pages.user.mpesa-checkout', [
                    'nav'   => 'mpesa-checkout',
                    'title' => 'Mpesa Checkout',
                    'user'  =>  $user,
                    'event_request' => $event_request,
                    'options' => $this->_options,
                ]);


            }elseif($request->payment_method == 'cc'){
                return redirect()->route('user.paypal.request',['id'=>$event_request->id, 'type' => $type]);
            }
        }

        return view('pages.user.select-payment-method', [
            'nav'   => 'payment-method',
            'title' => 'Select Payment Method',
            'user'  =>  $user,
            'event_request' => $event_request,
            'options' => $this->_options,
        ]);
    }

    public function getMyEvents(Request $request){

    	if($request->has('search')){
    		$this->validate($request, [
    			'search' => 'max:255',
    		]);
    	}

    	$user = Auth::user();

    	$query = Event::query();

    	if($request->has('search') && !empty($request->search)){
    		$like_string = '%' . $request->search . '%';

    		$query->where('name','LIKE',$like_string);
    		$query->orWhere('venue','LIKE',$like_string);
    		$query->orWhere('location','LIKE',$like_string);
    		$query->orWhere('description','LIKE',$like_string);
            $query->orWhere('id',$request->search);
    	}

    	$events = $query->where('user_id', $user->id)->orderBy('created_at', 'DESC')->paginate($this->_pagination);

    	return view('pages.user.my-events', [
    		'title' 	=> 'My Events',
    		'nav' 		=> 'user.my-events',
    		'events'	=> $events,
            'today'     => $this->_date,
            'request'   =>$request,
            'options'   => $this->_options,
    	]);
    }

    public function getEngage(){
    	return view('pages.user.engage', [
    		'title' => 'Engage',
    		'nav' => 'user.engage',
    	]);
    }

    public function requestCard($username){
        $user = User::where('username', $username)->first();

        if(!$user){
            return view('errors.404');
        }

        $card = Card::where('user_id', $user->id)->first();

        if(!$card){
            if(!$user->card){
                $card = new Card;
                $card->user_id = $user->id;
                $card->save();
            }
        }

        $card_request = new CardRequest;

        $card_request->to_id        = $user->id;
        $card_request->from_id      = Auth::user()->id;
        $card_request->card_id      = $card->id;
        $card_request->approved     = 0;
        $card_request->save();

        $notification                       = new AppNotification;
        $notification->to_id                = $card_request->to_id;
        $notification->from_id              = $card_request->from_id;
        $notification->model_id             = $card_request->id;
        $notification->notification_type    = 'request.card.send';
        $notification->notification_status  = 'success';
        $notification->message              = ucfirst('you have a new card request from ');
        $notification->save();

        Session::flash('success', 'Card Request Sent');

        return redirect()->back();
    }

    public function printTicket($slug, $id){
        $event_request = EventRequest::findOrFail($id);

        $pdf = loadTicket($event_request);
        
        return $pdf->download('ticket.pdf');
    }

    public function approveCardRequest($id){
        $user = Auth::user();

        $card_request = CardRequest::find($id);

        if(!$card_request){
            return view('errors.404');
        }

        if($card_request->to_id == $user->id){
            if($card_request->approved == 0){
                $card_request->approved = 1;
                $card_request->approved_at = $this->_date;

                $card_request->update();

                $already = CardRequest::where('from_id', $user->id)->where('to_id', $card_request->from_id)->first();

                if(!$already){
                    $crd                = new CardRequest;
                    $crd->from_id       = $user->id;
                    $crd->to_id         = $card_request->from_id;
                    $crd->card_id       = $user->card->id;
                    $crd->approved      = 1;
                    $crd->approved_at   = $this->_date;
                    $crd->save();
                }
                
                $notification                       = new AppNotification;
                $notification->to_id                = $card_request->from_id;
                $notification->from_id              = $card_request->to_id;
                $notification->model_id             = $card_request->id;
                $notification->notification_type    = 'request.card.approve';
                $notification->notification_status  = 'success';
                $notification->message              = ucfirst('card request has been approved by ');
                $notification->save();

                Session::flash('success', 'Card Request approved');
            }else{
                Session::flash('success', 'Card Request approved');
            }
        }else{
            Session::flash('error', 'Forbidden');
        }

        return redirect()->back();
    }

    public function declineCardRequest($id){
        $card_request = CardRequest::find($id);

        if(!$card_request){
            return view('errors.404');
        }


        if($card_request->to_id == Auth::user()->id){

            $card_request->forceDelete();

            Session::flash('success', 'Card Request declined');
            
        }else{
            Session::flash('error', 'Forbidden');
        }

        return redirect()->back();
    }

    public function getConversations(Request $request){
        $user = Auth::user();
        $conversations = Conversation::where('to_id', $user->id)->orWhere('from_id', $user->id)->orderBy('updated_at', 'DESC')->get();

        $my_notifications = $user->message_notifications()->where('read', 0)->get();
        
        foreach ($my_notifications as $r) {
            $r->read = 1;
            $r->read_at = $this->_date;
            $r->update();
        }

        return view('pages.user.messages',[
            'title'         => 'Conversations',
            'nav'           => 'user.messages',
            'user'          => $user,
            'conversations' => $conversations,
        ]);
    }

    public function newMessage(Request $request, $recepient){
        $recepient  = User::where('username', $recepient)->first();
        $sender     = Auth::user();
        $user       = $sender;

        if(!$recepient){
            return view('errors.404');
        }

        if($recepient->id == $sender->id){
            Session::flash('error', 'Sorry, you cant message yourself');
            return redirect()->back();
        }

        $from_conversation = Conversation::where('from_id', $sender->id)->where('to_id', $recepient->id)->first();
        $to_conversation =   Conversation::where('from_id', $recepient->id)->where('to_id', $sender->id)->first();
        
        if($from_conversation){
            $conversation = $from_conversation;
        }elseif($to_conversation){
            $conversation = $to_conversation;
        }else{
            $conversation = new Conversation;
            $conversation->to_id = $recepient->id;
            $conversation->from_id = $sender->id;
            $conversation->save();
        }

        $conversations = Conversation::where('to_id', $user->id)->orWhere('from_id', $user->id)->orderBy('updated_at', 'DESC')->get();

        $new_messages = $conversation->messages()->where('to_id', $user->id)->where('read', 0)->orderBy('created_at', 'DESC')->get();


        $my_notifications = $conversation->notifications()->where('to_id', $user->id)->where('read', 0)->get();
        $my_messages = $conversation->messages()->where('to_id', $user->id)->where('read', 0)->get();
        
        foreach ($my_notifications as $r) {
            $r->read = 1;
            $r->read_at = $this->_date;
            $r->update();
        }


        foreach ($my_messages as $r) {
            $r->read = 1;
            $r->read_at = $this->_date;
            $r->update();
        }


        if($request->ajax()){
            $messages = [];

            if(count($new_messages)){
                foreach ($new_messages as $message) {
                    if($user->id == $message->sender->id){
                        $owner = 'me';
                    }else{
                        $owner = 'you';
                    }

                    $messages[] = [
                        'name'      => $message->sender->name,
                        'message'   => $message->message,
                        'time'      => $message->created_at->diffForHumans(),
                        'owner'     => $owner,
                    ];
                }
            }
            
            return response()->json(['status' => 200, 'count' => count($new_messages), 'messages' => $messages]);
        }

        return view('pages.user.message',[
            'title'         => 'Conversation',
            'nav'           => 'user.message',
            'sender'        => $sender,
            'recepient'     => $recepient,
            'conversation'  => $conversation,
            'conversations' => $conversations,
            'user'          => $user,
        ]);
    }

    public function postMessage(Request $request, $recepient){
        $this->validate($request, [
            'message' => 'required',
        ]);

        $recepient  = User::where('username', $recepient)->first();
        $sender     = Auth::user();
        $user       = $sender;

        if(!$recepient){
            $message = 'Recepient not found';

            if($request->ajax()){
                $response = ['status' => 404, 'message' => $message];
                return response()->json($response);
            }

            return view('errors.404');
        }

        if($recepient->id == $sender->id){

            $message = 'Sorry, you cant message yourself';

            if($request->ajax()){
                $response = ['status' => 403, 'message' => $message];
                return response()->json($response);
            }

            Session::flash('error', $message);
            
            return redirect()->back();
        }

        $from_conversation  = Conversation::where('from_id', $sender->id)->where('to_id', $recepient->id)->first();
        $to_conversation    =   Conversation::where('from_id', $recepient->id)->where('to_id', $sender->id)->first();

        if($from_conversation){
            $conversation = $from_conversation;
        }elseif($to_conversation){
            $conversation = $to_conversation;
        }else{
            $conversation           = new Conversation;
            $conversation->to_id    = $recepient->id;
            $conversation->from_id  = $sender->id;
            $conversation->save();
        }

        $message                    = new Message;
        $message->from_id           = $user->id;
        $message->to_id             = $recepient->id;
        $message->conversation_id   = $conversation->id;
        $message->message           = ucfirst($request->message);
        $message->save();

        $message_notification           = new MessageNotification;
        $message_notification->from_id  = $user->id;
        $message_notification->to_id    = $recepient->id;
        $message_notification->conversation_id    = $conversation->id;
        $message_notification->message_id    = $message->id;
        $message_notification->save();

        $conversation->updated_at = $this->_date;
        $conversation->update();

        $message = 'Message sent';

        if($request->ajax()){
            $response = ['status' => 200, 'message' => $message];
            return response()->json($response);
        }

        Session::flash('success', $message);

        return redirect()->back();
    }

    public function getMyCards(){
        $user = Auth::user();

        $card_requests = $user->card_requests()->where('approved', 0)->orderBy('created_at', 'desc')->get();
        $card_requests_count = count($card_requests);
        $card_requests = $user->card_requests()->where('approved', 0)->orderBy('created_at', 'desc')->limit('10')->get();
        
        $approved_requests = $user->sent_requests()->where('approved', 1)->orderBy('approved_at', 'desc')->get();
        $approved_requests_count = count($approved_requests);
        $approved_requests = $user->sent_requests()->where('approved', 1)->orderBy('approved_at', 'desc')->limit('10')->get();

        return view('pages.user.my-cards',[
            'title' => 'My Cards',
            'nav'   => 'user.my-cards',

            'card_requests'             => $card_requests,
            'card_requests_count'       => $card_requests_count,
            'approved_requests'         => $approved_requests,
            'approved_requests_count'   => $approved_requests_count,
        ]);
    }

    public function getPeopleWithMyCard(){
        $user = Auth::user();

        $card_requests = $user->card_requests()->where('approved', 1)->orderBy('created_at','desc')->get();

        return view('pages.user.people-with-my-card',[
            'title'         => 'People with my Card',
            'nav'           => 'user.people-with-my-card',
            'card_requests' => $card_requests,
        ]);
    }

    public function getCardRequests(){
        $user = Auth::user();

        $card_requests = $user->card_requests()->where('approved', 0)->orderBy('created_at', 'desc')->get();

        return view('pages.user.card-requests',[
            'title'         => 'Card Requests',
            'nav'           => 'user.card-requests',
            'user'          => $user,
            'card_requests' => $card_requests,
        ]);
    }

    public function getNotification($id){
        $notification = AppNotification::find($id);
        $user = Auth::user();

        if(!$notification) {
            return view('errors.404');
        }

        if($notification->to_id != $user->id){
            Session::flash('error', 'Forbidden');

            return redirect()->back();
        }

        $notification->read = 1;
        $notification->read_at = $this->_date;
        $notification->update();

        if($notification->notification_type == 'request.card.send'){
            return redirect()->route('user.card-requests');
        }

        elseif($notification->notification_type == 'request.card.approve'){
            return redirect()->route('user.my-cards');
        }


        elseif($notification->notification_type == 'event.request.send'){
            return redirect()->route('user.event-requests');
        }

        //,,,,,,,,,,,,,,,,,,,,,,,,

        elseif($notification->notification_type == 'event.request.approve'){
            $user = Auth::user();
            $event_request = EventRequest::find($notification->model_id);

            if($event_request->from_id != $user->id){
                Session::flash('error', 'Forbidden');
                return redirect()->back();
            }

            $event = $event_request->event;

            if(!$event){
                return view('errors.404');
            }
            
            return redirect()->route('event.view', ['slug'=> $event->slug]);
        }

        elseif($notification->notification_type == 'event.request.decline'){
            $user = Auth::user();
            $event_request = EventRequest::find($notification->model_id);

            if($event_request->from_id != $user->id){
                Session::flash('error', 'Forbidden');
                return redirect()->back();
            }

            $event = $event_request->event;

            if(!$event){
                return view('errors.404');
            }
            
            return redirect()->route('event.view', ['slug' => $event->slug]);
        }

        elseif($notification->notification_type == 'event.interested'){
            $user = Auth::user();
            $event_request = EventRequest::find($notification->model_id);

            if($event_request->to_id != $user->id){
                Session::flash('error', 'Forbidden');
                return redirect()->back();
            }

            $event = $event_request->event;

            if(!$event){
                return view('errors.404');
            }
            
            return redirect()->route('event.view', ['slug' => $event->slug]);
        }

        elseif($notification->notification_type == 'event.attending'){
            $user = Auth::user();
            $event_request = EventRequest::find($notification->model_id);

            if($event_request->to_id != $user->id){
                Session::flash('error', 'Forbidden');
                return redirect()->back();
            }

            $event = $event_request->event;

            if(!$event){
                return view('errors.404');
            }
            
            return redirect()->route('user.event.attendees', ['slug' => $event->slug]);
        }

        elseif($notification->notification_type == 'request.balance.paid'){
            $user = Auth::user();
            $event_request = EventRequest::find($notification->model_id);

            if($event_request->to_id != $user->id){
                Session::flash('error', 'Forbidden');
                return redirect()->back();
            }

            $event = $event_request->event;

            if(!$event){
                return view('errors.404');
            }
            
            return redirect()->route('user.event.attendees', ['slug' => $event->slug]);
        }
    }

    public function getNotifications(){
        $user = Auth::user();

        $notifications = $user->notifications()->orderBy('created_at', 'DESC')->get();

        return view('pages.user.notifications',[
            'title'         => 'Notifications',
            'nav'           => 'user.notifications',
            'user'          => $user,
            'notifications' => $notifications,
        ]);
    }

    public function getBookedEvents(Request $request){
       $user = Auth::user();

       $event_requests = $user->sent_event_requests()->orderBy('created_at', 'DESC')->paginate($this->_pagination);

       return view('pages.user.booked-events',[
            'title'             => 'Booked Events',
            'nav'               => 'user.booked-events',
            'user'              => $user,
            'event_requests'    => $event_requests,
            'request'           => $request,
            'today'             => $this->_date,
            'options'           => $this->_options,
        ]);
    }

    public function getEventRequests(){
        $user = Auth::user();

        $event_requests = $user->event_requests()->where('approved', '0')->orderBy('created_at', 'DESC')->get();
        
        return view('pages.user.event-requests', [
            'nav'               => 'user.event-requests',
            'title'             => 'Event Requests',
            'event_requests'    => $event_requests,
        ]);
    }

    public function approveEventRequest($id){
        $user = Auth::user();

        $event_request = EventRequest::find($id);

        if(!$event_request){
            Session::flash('error', 'Request not found');
            return view('errors.404');
        }

        $event = $event_request->event;

        if(!$event){
            Session::flash('error', 'Event not found');
            return view('errors.404');
        }

        if($event->user_id != $user->id){
            Session::flash('error', 'Forbidden');

            return redirect()->back();
        }

        $event_request->approved        = 1;
        $event_request->approved_at     = $this->_date;

        if(!$event_request->amount_due){
            $event_request->paid = 1;
        }

        $event_request->update();


        $notification = new AppNotification;
        $notification->from_id = $event_request->to_id;
        $notification->to_id = $event_request->from_id;
        $notification->model_id = $event_request->id;
        $notification->notification_type = 'event.request.approve';
        $notification->notification_status = 'success';
        $notification->message = ucfirst('your event request was approved by ');
        $notification->save();



        Session::flash('success', 'Request approved');
        return redirect()->back();
    }

    public function rejectEventRequest($id){
        $user = Auth::user();

        $event_request = EventRequest::find($id);

        if(!$event_request){
            Session::flash('error', 'Request not found');
            return view('errors.404');
        }

        $event = $event_request->event;

        if(!$event){
            Session::flash('error', 'Event not found');
            return view('errors.404');
        }

        if($event->user_id != $user->id){
            Session::flash('error', 'Forbidden');

            return redirect()->back();
        }

        $event_request->forceDelete();


        $notification = new AppNotification;
        $notification->from_id = $event_request->to_id;
        $notification->to_id = $event_request->from_id;
        $notification->model_id = $event_request->id;
        $notification->notification_type = 'event.request.decline';
        $notification->notification_status = 'success';
        $notification->message = ucfirst('your event request was declined by ');
        $notification->save();

        Session::flash('success', 'Request declined');
        return redirect()->back();
    }

    public function getTransactions(){
        $user = Auth::user();

        $transactions = $user->transactions()->orderBy('created_at', 'DESC')->paginate($this->_pagination);

        return view('pages.user.transactions',[
            'nav'           => 'user.transactions',
            'title'         => 'Transactions',
            'user'          => $user,
            'transactions'  => $transactions,
            'options'       => $this->_options,
        ]);
    }

    public function addEventTag(Request $request, $slug){
        $user = Auth::user();

        $this->validate($request, [
            'name'  => 'required',
        ]);

        $event = Event::where('slug', $slug)->first();

        if(!$event){
            return view('errors.404');
        }

        if($user->id != $event->user_id){
            $message = 'Forbidden';
            Session::flash('error', $message);
        }

        $tag = new EventTag;
        $tag->name = remove_special($request->name);
        $tag->event_id = $event->id;
        $tag->save();

        $message = 'Tag added';

        Session::flash('success', $message);

        return redirect()->back();
    }

    public function deleteEventTag($id){
        $user = Auth::user();

        $event_tag = EventTag::find($id);

        if(!$event_tag){
            return view('errors.404');
        }

        if($event_tag->event->user->id != $user->id){
            $message = 'Forbidden';
            Session::flash('error', $message);
        }

        $event_tag->forceDelete();

        $message = 'Tag Removed';

        Session::flash('success', $message);

        return redirect()->back();
    }

    public function addSponsor(Request $request, $slug){
        $event = Event::where('slug', $slug)->firstOrFail();

        $this->validate($request, [
            'name'  => 'required|max:255',
            'type'  => 'required|max:255',
        ]);

        $sponsor = new Sponsor;

        if($request->hasFile('logo') && $request->file('logo')->isValid()){
            $this->validate($request, [
                'logo'  => 'mimes:jpg,jpeg,png,bmp|min:0.001|max:40960',
            ]);

            $file       = $request->file('logo');

            try{
                $ext        = $file->getClientOriginalExtension();
                
                $fileName   = 'image_'. time() . rand(1,10000) . '.' . $ext;
                $path       = $this->_image_path . '\\' . $fileName;

                $canvas = Image::canvas(245,245);

                $image = Image::make($file)->orientate()->resize(245,245, function($constraint){
                    $constraint->aspectRatio();
                });

                $canvas->insert($image, 'center')->save($path);

                $sponsor->logo = $fileName;

            }catch(Exception $e){
                Session::flash('error', $e->getMessage());
                return redirect()->back();
            }
        }

        $sponsor->event_id  = $event->id;
        $sponsor->name      = $request->name;
        $sponsor->type      = $request->type;
        $sponsor->save();

        Session::flash('success', 'Added');

        return redirect()->back();
    }

    public function deleteSponsor(Request $request, $id){
        $sponsor = Sponsor::findOrFail($id);

        if($sponsor->logo){
            $path = $this->_image_path . '\\' . $sponsor->logo;
            @unlink($path);
        }

        $sponsor->delete();

        Session::flash('success', 'Deleted');

        return redirect()->back();

    }

    public function closeAccount(Request $request){
        $this->validate($request, [
            'reason' => 'max:400',
        ]);

        $user = auth()->user();

        $user->closed = 1;
        $user->closed_by = $user->id;
        $user->closed_at = $this->_date;
        $user->closed_reason = $request->reason;

        $user->update();

        auth()->logout();

        Session::flash('success', 'Account closed');

        return redirect()->route('login');
    }
}
