@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title"> @yield('title') ({{ number_format(count($attendees)) }})</h3>
				
				@if(count($attendees))
					<table class="table color-table inverse-table">
						<thead>
							<tr>
								<th>Event</th>
								<th>Paid At</th>
								<th>Approved At</th>
								<th>Amount Paid</th>
								<th>Payment Type</th>
								<th>Currency</th>
								<th>Ticket</th>
								
							</tr>
						</thead>

						<tbody>
							@foreach($attendees as $request)
								<tr>
									<td>
										<a href="{{ route('admin.event', ['slug' => $request->event->slug]) }}">
											{{ $request->event->name }}
										</a>
									</td>
									<td>{{ niceDate($request->paid_at) . ', '. niceTime($request->paid_at) }}</td>
									<td>{{ niceDate($request->approved_at) . ', '. niceTime($request->approved_at) }}</td>
									<td>{{ number_format($request->amount_paid,2) }}</td>
									<td>{{ $request->payment_type }}</td>
									<td>{{ $request->currency }}</td>
									<td><strong>{{ $request->code }}</strong></td>
									
								</tr>
							@endforeach
							
						</tbody>
					</table>
				@else
					<p>No Attendees</p>
				@endif

	            
	        </div> 
	        

	    </div>
	</div>
@endsection