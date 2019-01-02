@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title"> @yield('title') ({{ number_format($users->total()) }})</h3>

	            @if(count($users))
					<table class="table color-table inverse-table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Username</th>
								<th>Email</th>
								<th>Country</th>
								<th>Events</th>
								<th>Joined</th>
								<th>Last Seen</th>
								<th>Status</th>
								<th></th>
							</tr>
						</thead>

						<tbody>
							@foreach($users as $user)
								<tr>
									<td>{{ $user->name }}</td>
									<td>{{ $user->username }}</td>
									<td>{{ $user->email }}</td>
									<td>{{ $user->country->name }}</td>
									<td>{{ number_format(count($user->events)) }}</td>
									
									<td>{{ niceDate($user->created_at) . ', ' . niceTime($user->created_at) }}</td>
									<td>{{ niceDate($user->last_seen) . ', ' . niceTime($user->last_seen) }}</td>
									
									<td>
										@if($user->closed)
											<span class="label label-table label-danger">CLOSED</span>
										@elseif($user->suspended)
											<span class="label label-table label-waring">SUSPENDED</span>
										@else
											<span class="label label-table label-success">ACTIVE</span>
										@endif
									</td>

									<td>
										<a href="{{ route('admin.user', ['username' => $user->username]) }}" class="btn">
											<i class="fa fa-eye"></i>
										</a>
									</td>
									
								</tr>
							@endforeach
						</tbody>


					</table>

					{{ $users->links() }}
				@else
					<hr>
					No Users
				@endif
	            
	        </div> 
	        

	    </div>
	</div>
@endsection