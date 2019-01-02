@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title"> @yield('title') ({{ number_format($events->total()) }})</h3>
	            
	            @if(count($events))
					<table class="table color-table inverse-table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Date</th>
								<th>Posted</th>
								<th>Posted By</th>
								<th>Attending</th>
								<th>Status</th>
								<th></th>
							</tr>
						</thead>

						<tbody>
							@foreach($events as $event)
								<tr>
									<td>{{ $event->name }}</td>
									<td>
										{{ defaultDate($event->start_date) == defaultDate($event->end_date) ? niceDate($event->start_date) : niceDate($event->start_date) . ' - ' . niceDate($event->end_date) }} 

                        				{{ ' (' . $event->start_time .' - '. $event->end_time . ')' }}
									</td>

									<td>
										{{ niceDate($event->created_at) .', '. niceTime($event->created_at)}}	
									</td>

									<td>
										{{ $event->user->name }}	
									</td>

									<td>
										{{ number_format($event->requests()->where('paid', 1)->where('approved', '1')->count()) }}
									</td>

									<td>
										@if(!$event->closed)
											{{ $event->start_date->lte($today) ? 'ENDED' : 'ACTIVE' }}
										@else
											CLOSED
										@endif
										
									</td>

									<td>
										<a href="{{ route('admin.event', ['slug' => $event->slug]) }}">
											<i class="fa fa-eye"></i>
										</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>

					{{ $events->links() }}
	            @else
					No Events
	            @endif
	        </div> 
	        

	    </div>
	</div>
@endsection