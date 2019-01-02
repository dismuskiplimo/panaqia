@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-2">
	        <div class="white-box">
	            <img src="{{ profile_pic($user->image) }}" alt="{{ $user->name }}" class="img-responsive pb-20">

	        </div> 

	        <div class="text-center">
	        	<p>
	        		<strong>Views:</strong> ({{ $user->views }})
	        	</p>
	        	
	        	<p>
	        		<a href="{{ route('admin.user.events', ['username' => $user->username]) }}" class="btn btn-info btn-block">
	        			<small>
	        				Events Posted ({{ number_format(count($user->events)) }})
	        			</small>
	        		</a> 
	        	</p>
				
				<p>
	        		<a href="{{ route('admin.user.events.attended', ['username' => $user->username]) }}" class="btn btn-primary btn-block">
	        			<small>
	        				Events Attended ({{ number_format(count($user->sent_event_requests()->where('approved', 1)->where('paid', 1))) }})
	        			</small>
	        		</a>
	        	</p>
	        </div>
			
			
	        	
	    </div>

	    <div class="col-md-5">
	        <div class="white-box">
	            
	            <h3 class="box-title">Name:</h3>
	            <p>{{ $user->name }}</p> <br>

	            <h3 class="box-title">Username:</h3>
	            <p>{{ '@' . $user->username }}</p> <br>

	            <h3 class="box-title">Email:</h3>
	            <p>{{ $user->email }}</p> <br>

	            <h3 class="box-title">Country:</h3>
	            <p>{{ $user->country->name }}</p> <br>
    
	        </div> 
	    </div>

	    <div class="col-md-5">
	        <div class="white-box">
	            <h3 class="box-title">Joined:</h3>
	            <p>{{ niceDate($user->created_at) . ', ' . niceTime($user->created_at) }}</p> <br>

	            
	            <h3 class="box-title">Last Seen:</h3>
	            <p>{{ niceDate($user->last_seen) . ', ' . niceTime($user->last_seen) }}</p> <br>

	            <h3 class="box-title">Company:</h3>
	            <p>{{ $user->name_of_company }} &nbsp;</p> <br>

	            <h3 class="box-title">Position:</h3>
	            <p>{{ $user->country->position }} &nbsp;</p> <br>
    
	        </div> 
	    </div>
	</div>
@endsection