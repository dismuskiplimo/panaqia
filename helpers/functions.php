<?php
	function my_asset($asset){
		if(config('app.https') == true){
			return secure_asset($asset);
		}else{
			return asset($asset);
		}
	}

	function profile_pic($asset = ''){
		$path = base_path() . '\\' . env('PUBLIC_PATH') . '\\' . 'img\\uploads\\';

		$file = $path . $asset;

		if($asset){
			if(file_exists($file)){
				return my_asset('img/uploads/' . $asset);
			}else{
				return my_asset('img/default-user.png');	
			}
		}else{
			return my_asset('img/default-user.png');
		}
	}	

	function profile_thumb($asset = ''){
		$path = base_path() . '\\' . env('PUBLIC_PATH') . '\\' . 'img\\uploads\\thumbnails\\';

		$file = $path . $asset;

		if($asset){
			if(file_exists($file)){
				return my_asset('img/uploads/thumbnails/' . $asset);
			}else{
				return my_asset('img/default-user.png');	
			}
		}else{
			return my_asset('img/default-user.png');
		}
	}

	function image($asset = '', $type=''){
		$path = base_path() . '\\' . env('PUBLIC_PATH') . '\\' . 'img\\uploads\\';

		$file = $path . $asset;

		$not_found = '300x200.png';

		if($type == 'event'){
			$not_found = '400x225.png';
		}

		if($type == 'featured'){
			$not_found = '1920x950.jpg';
		}

		if($type == 'sponsor'){
			$not_found = 'logo-404.png';
		}

		if($type == 'user'){
			$not_found = 'default-user.png';
		}

		if($asset != '' && !is_null($asset)){
			if(file_exists($file)){
				return my_asset('img/uploads/' . $asset);
			}else{
				return my_asset('img/' . $not_found);	
			}
		}else{
			return my_asset('img/' . $not_found);
		}
	}


	function thumbnail($asset = '', $type = ''){
		$path = base_path() . '\\' . env('PUBLIC_PATH') . '\\' . 'img\\uploads\\thumbnails\\';

		$file = $path . $asset;

		$not_found = '300x200.png';

		if($type == 'event'){
			$not_found = '400x225.png';
		}

		if($asset){
			if(file_exists($file)){
				return my_asset('img/uploads/thumbnails/' . $asset);
			}else{
				return my_asset('img/' . $not_found);	
			}
		}else{
			return my_asset('img/' . $not_found);
		}
	}


	function featured_image($asset = ''){
		$path = base_path() . '\\' . env('PUBLIC_PATH') . '\\' . 'img\\uploads\\featured_images\\';

		$file = $path . $asset;

		$not_found = '1920x950.jpg';

		if($asset){
			if(file_exists($file)){
				return my_asset('img/uploads/featured_images/' . $asset);
			}else{
				return my_asset('img/' . $not_found);	
			}
		}else{
			return my_asset('img/' . $not_found);
		}
	}


	if (! function_exists('words')) {
	    /**
	     * Limit the number of words in a string.
	     *
	     * @param  string  $value
	     * @param  int     $words
	     * @param  string  $end
	     * @return string
	     */
	    function words($value, $words = 100, $end = '...'){
	        return \Illuminate\Support\Str::words($value, $words, $end);
	    }
	}


	if (! function_exists('characters')) {
	    /**
	     * Limit the number of words in a string.
	     *
	     * @param  string  $value
	     * @param  int     $words
	     * @param  string  $end
	     * @return string
	     */
	    function characters($value, $characters = 100, $end = '...'){
	        return \Illuminate\Support\Str::limit($value, $characters, $end);
	    }
	}

    function niceDate(\Carbon\Carbon $date){
    	return $date->format('D, M d, Y');
    }

    function niceTime(\Carbon\Carbon $date){
    	return $date->format('g:i A');
    }


    function defaultDate(\Carbon\Carbon $date){
    	return $date->format('Y-m-d');
    }

    function fullDate(\Carbon\Carbon $date){
    	return $date->format('D, M d, Y') . ', ' . $date->format('g:i A');
    }


	function remove_special($string) {
		$string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

		return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
	}

	function generateRandomString($length = 10) {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}

		return $randomString;
	}

	function get_file_extension($file_name) {
		return substr(strrchr($file_name,'.'),1);
	}

	function resource_exists($url){
		$resourceExists = false;
		 
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_exec($ch);
		$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		 
		//200 = OK
		if($statusCode == '200'){
		    $resourceExists = true;
		}

		return $resourceExists;	
	}


	function attending_as($type = ''){
		if($type == 'SPEAKER'){
			$type = 'SPEAKER';
		}elseif($type == 'ATTENDEE' || $type == 'DELEGATE'){
			$type = 'DELEGATE';
		}else{
			$type = 'EXHIBITOR';
		}

		return $type;
	}

	function names($string){
		return explode(' ', $string);
	}


	function loadTicket(\App\EventRequest $event_request){
        if (!ini_get('allow_url_fopen')) {
            @ini_set('allow_url_fopen', 1);
        }

        $path = base_path() . '\\' . env('PUBLIC_PATH') . '\\' . 'img\\';

        $pic_path = $path . 'uploads\\' . $event_request->user->image;

        if($event_request->user->image && file_exists($pic_path)){
            
        }else{
            $pic_path = $path . 'default-user.png.';
        }

        $logo_path = $path . 'blue-logo.png.';

        try{
            $pic = (string) \Image::make($pic_path)->fit(200,200)->encode('data-url');
            $logo = (string) \Image::make($logo_path)->fit(200,200)->encode('data-url');
            
        }catch(\Exception $e){
            $pic = '';
            $logo = '';
        }

        $pdf = \PDF::loadView('pdf.ticket', ['event_request' => $event_request, 'pic'=> $pic, 'logo' => $logo]);
        $pdf->setPaper('letter', 'landscape');

        return $pdf; 
   
	}
	
	
?>