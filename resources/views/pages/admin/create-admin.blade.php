@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            
	            
	            <h3 class="box-title">Basic Information</h3>
	            
	            <form class="form-material form-horizontal" method="POST" action="">
	                @csrf

	                <div class="form-group">
	                    <label class="col-md-12" for="name">Name
	                    </label>
	                    <div class="col-md-12">
	                        <input id="name" name="name" class="form-control" placeholder="name" type="text" required=""> </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-md-12" for="username">Username
	                    </label>
	                    <div class="col-md-12">
	                        <input id="username" name="username" class="form-control" placeholder="username" type="text" required=""> </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-md-12" for="email">Email
	                    </label>
	                    <div class="col-md-12">
	                        <input id="email" name="email" class="form-control" placeholder="email" type="email" required=""> </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-md-12" for="country">Country
	                    </label>

	                    <div class="col-md-12">
	                    	<select id="country" name="country_code" class="form-control" required="">
		                    	<option value=""> --Select Country-- </option>
		                    	@foreach($countries as $country)
									<option value="{{ $country->code }}">{{ $country->name }}</option>
		                    	@endforeach
		                    </select>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-md-12" for="password">Password
	                    </label>
	                    <div class="col-md-12">
	                        <input id="password" name="password" class="form-control" placeholder="password" type="password" required=""> </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-md-12" for="password_confirmation">Repeat Password
	                    </label>
	                    <div class="col-md-12">
	                        <input id="password_confirmation" name="password_confirmation" class="form-control" placeholder="repeat password" type="password" required=""> </div>
	                </div>

	                <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">Create Admin</button>
	                
	            </form>
	        </div> 
	        

	    </div>
	</div>

	
@endsection