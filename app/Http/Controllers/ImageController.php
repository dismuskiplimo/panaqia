<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Image;

use App\User;

use App\Card;

use App\Event;

use Carbon\Carbon;

use Session;

class ImageController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
		
        $this->initialize_options();
	}

    public function updateCardBackground(Request $request, $id){
    	if($request->hasFile('image') && $request->file('image')->isValid()){
    		$this->validate($request,[
    			'image' => 'mimes:jpg,jpeg,png,bmp|min:0.001|max:40960',
    		]);

    		$card = Card::find($id);

            if(!$card){
            	$message = 'Card not found';
                Session::flash('error', $message);
                return redirect()->back();
            }

    		if(!empty($card->background)){
	    		
	    		$image_path = $this->_image_path . '\\' . $card->background;

	    		$card->background = null;
	   
	    		@unlink($image_path);
	    	}
		
			try{

                $file       = $request->file('image');
                
                $ext        = $file->getClientOriginalExtension();
                
                $fileName   = 'image_'. time() . rand(1,10000) . '.' . $ext;
                $path       = $this->_image_path . '\\' . $fileName;

                Image::make($file)->orientate()->fit(600,350)->save($path);

                $card->background = $fileName;
                $card->update();
            }catch(\Exception $e){
                Session::flash('error', 'Image Update failed. Reason: ' . $e->getMessage());
                return redirect()->back();
            }

    	}

    	return redirect()->back();
    }

    public function updateCardThumbnail(Request $request, $id){
    	if($request->hasFile('image') && $request->file('image')->isValid()){
    		$this->validate($request,[
    			'image' => 'mimes:jpg,jpeg,png,bmp|min:0.001|max:40960',
    		]);

    		$card = Card::find($id);

            if(!$card){
            	$message = 'Card not found';
                Session::flash('error', $message);
                return redirect()->back();
            }

    		if(!empty($card->thumbnail)){
	    		
	    		$image_path = $this->_image_path . '\\' . $card->thumbnail;

	    		$card->thumbnail = null;
	   
	    		@unlink($image_path);
	    	}
			
			
            try{

                $file       = $request->file('image');
                
                $ext        = $file->getClientOriginalExtension();
                
                $fileName   = 'image_'. time() . rand(1,10000) . '.' . $ext;
                $path       = $this->_image_path . '\\' . $fileName;

                Image::make($file)->orientate()->fit(450,450)->save($path);

                $card->thumbnail = $fileName;
                $card->update();
            }catch(\Exception $e){
                Session::flash('error', 'Image Update failed. Reason: ' . $e->getMessage());
                return redirect()->back();
            }

    	}

    	return redirect()->back();
    }

    public function updateUserImage(Request $request){
    	if($request->hasFile('image') && $request->file('image')->isValid()){
    		$this->validate($request,[
    			'image' => 'mimes:jpg,jpeg,png,bmp|min:0.001|max:40960',
    		]);

    		$user = Auth::user();

            if(!$user){
            	$message = 'User not found';
                Session::flash('error', $message);
                return redirect()->back();
            }

    		if(!empty($user->thumbnail) && !empty($user->image)){
	    		
	    		$image_path = $this->_image_path . '\\' . $user->image;
	    		$thumbnail_path = $this->_image_path . '\\thumbnails\\' . $user->thumbnail;

	    		$user->image = null;
	    		$user->thumbnail = null;
	   
	    		@unlink($image_path);
	    		@unlink($thumbnail_path);
	    	}

			try{

                $file       = $request->file('image');

                $ext        = $file->getClientOriginalExtension();

                $fileName   = 'image_'. time(). rand(1,10000) . '.' . $ext;
                $thumbName  = 'thumb_'. time(). rand(1,10000) . '.' . $ext;
                
                $image_path         = $this->_image_path . '\\' . $fileName;
                $thumbnail_path     = $this->_image_path . '\\thumbnails\\' . $thumbName;

                Image::make($file)->orientate()->fit(450,450)->save($image_path);
                Image::make($file)->orientate()->fit(64,64)->save($thumbnail_path);

                $user->image = $fileName;
                $user->thumbnail = $thumbName;
                $user->update();

            }catch(\Exception $e){
                Session::flash('error', 'Image Update failed. Reason: ' . $e->getMessage());
                return redirect()->back();
            }

            
    	}

    	return redirect()->back();
    }



    public function updateEventBanner(Request $request, $id){
    	if($request->hasFile('banner') && $request->file('banner')->isValid()){
    		$this->validate($request,[
    			'banner' => 'mimes:jpg,jpeg,png,bmp|min:0.001|max:40960|required',
    		]);

    		$event = Event::find($id);

            if(!$event){
            	$message = 'Event not found';
                Session::flash('error', $message);
                return redirect()->back();
            }

    		if(!empty($event->banner)){
	    		
                $image_path = $this->_image_path . '\\' . $event->banner;
                $featured_path = $this->_image_path . '\\featured_images\\' . $event->featured_image;
	    		$thumb_path = $this->_image_path . '\\thumbnails\\' . $event->thumbnail;

                $event->banner          = null;
                $event->banner          = null;
	    		$event->featured_image  = null;
	   
                @unlink($image_path);
                @unlink($featured_path);
	    		@unlink($thumb_path);
	    	}

			try{
                $rand       = rand(1,100000);
                $file           = $request->file('banner');
                
                $ext            = $file->getClientOriginalExtension();
                
                $bannerName     = 'banner_'. time() . $rand . '.' . $ext;
                $featuredName   = 'featured_'. time() . $rand . '.' . $ext;
                $thumbName      = 'thumbnail_'. time() . $rand . '.' . $ext;
                
                $image_path = $this->_image_path . '\\' . $bannerName;
                $featured_path = $this->_image_path . '\\featured_images\\' . $featuredName;
                $thumb_path = $this->_image_path . '\\thumbnails\\' . $thumbName;

                Image::make($file)->orientate()->resize(1024,null, function($constraint){
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($image_path);

                Image::make($file)->orientate()->fit(1920, 950)->save($featured_path);
                
                Image::make($file)->orientate()->fit(400, 225)->save($thumb_path);

                $event->banner          = $bannerName;
                $event->featured_image  = $featuredName;
                $event->thumbnail       = $thumbName;
                $event->update();

            }catch(\Exception $e){
                Session::flash('error', 'Banner Update failed. Reason: ' . $e->getMessage());
                return redirect()->back();
            }
    	}

    	return redirect()->back();
    }
}
