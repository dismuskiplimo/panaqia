@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-4">
	        <div class="white-box text-center">
	            <img src="{{ profile_pic($admin->image) }}" alt="{{ $admin->name }}" class="img-responsive pb-20">

	            @if(!$me)
		            @if($admin->suspended)
						<form action="{{ route('admin.user.activate', ['username' => $admin->username]) }}" method = "POST">
							@csrf

							<button type="submit" class="btn btn-info">ACTIVATE ADMIN</button>
						</form>
		            @else
						<form action="{{ route('admin.user.suspend', ['username' => $admin->username]) }}" method = "POST">
							@csrf

							<button type="submit" class="btn btn-danger">SUSPEND ADMIN</button>
						</form>
		            @endif
	            @endif

	        </div> 
	    </div>

	    <div class="col-md-8">
	        <div class="white-box">
	            <h3 class="box-title">Name</h3>
	            <p>{{ $admin->name }}</p> <br>

	            <h3 class="box-title">Username</h3>
	            <p>{{ '@' . $admin->username }}</p> <br>

	            <h3 class="box-title">Email</h3>
	            <p>{{ $admin->email }}</p> <br>

	            <h3 class="box-title">Country</h3>
	            <p>{{ $admin->country->name }}</p> <br>
    
	        </div> 
	    </div>


	</div>

	


@endsection