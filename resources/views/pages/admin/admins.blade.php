@extends('layouts.admin')

@section('title', $title)

@section('content')

	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title"> @yield('title') ({{ number_format($admins->total()) }})
					<a href="{{ route('admin.create-admin') }}" class="btn btn-info pull-right">
	            		<i class="fa fa-plus"></i> ADD ADMIN
	            	</a>
	            </h3>
	            
	            

				@if(count($admins))
					<table class="table color-table inverse-table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Registered</th>
								<th>Last Seen</th>
								<th>Status</th>
								<th></th>
							</tr>
						</thead>

						<tbody>
							@foreach($admins as $admin)
								<tr>
									<td>{{ $admin->name }}</td>
									<td>{{ niceDate($admin->created_at) . ', ' . niceTime($admin->created_at) }}</td>
									<td>{{ niceDate($admin->last_seen) . ', ' . niceTime($admin->last_seen) }}</td>
									<td>
										{!! $admin->suspended ? '<span class="label label-table label-danger">SUSPENDED</span>' : '<span class="label label-table label-success">ACTIVE</span>' !!}
									</td>
									<td><a href="{{ route('admin.admin', ['username' => $admin->username]) }}" class="btn"><i class="fa fa-eye"></i></a></td>
									
								</tr>
							@endforeach
						</tbody>


					</table>

					{{ $admins->links() }}
				@else
					<hr>
					No Admins
				@endif
	        </div> 
	        

	    </div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			
		</div>
	</div>

@endsection