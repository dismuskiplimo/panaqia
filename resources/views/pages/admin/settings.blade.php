@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-8">
	        <div class="white-box">
	            <h3 class="box-title">Name <a href=""  data-toggle = "modal" data-target = "#edit-admin-modal" class="pull-right btn btn-info"><i class="fa fa-edit"></i> EDIT</a></h3>
	            <p>{{ $admin->name }}</p> <br>

	            <h3 class="box-title">Username</h3>
	            <p>{{ '@' . $admin->username }}</p> <br>

	            <h3 class="box-title">Email</h3>
	            <p>{{ $admin->email }}</p> <br>

	            <h3 class="box-title">Country</h3>
	            <p>{{ $admin->country->name }}</p> <br>
	            
	        </div> 
	        

	    </div>

	    <div class="col-md-4">
	        <div class="white-box">
	            <h3 class="box-title"> PASSWORD</h3>

	            <p>
	            	<a href="" data-toggle = "modal" data-target = "#change-password-modal" class="push-right btn btn-info"><i class="fa fa-key"></i> CHANGE PASSWORD</a>
	            </p>
	            
	        </div> 
	        

	    </div>
	</div>


	

	@include('pages.admin.modals.edit-admin')
	@include('pages.admin.modals.change-password')
@endsection