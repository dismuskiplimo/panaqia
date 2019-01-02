@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-4">
	        <div class="white-box">
	            <img src="{{ image($event->banner,'event') }}" alt="{{ $event->name }}" class="img-responsive">

	            <h3 class="box-title pt-20">ORGANIZER INFO</h3>
	            <table class="table">
	            	<tr>
	            		<th>Name</th>
	            		<td>{{ $event->user->name }}</td>
	            	</tr>

	            	<tr>
	            		<th>Company</th>
	            		<td>{{ $event->user->name_of_company }}</td>
	            	</tr>

	            	<tr>
	            		<th>Position</th>
	            		<td>{{ $event->user->position }}</td>
	            	</tr>

	            	
	            </table>
				
				<h4 class="box-title">Contacts</h4>
				
				<?php 
					$contacts = $event->user->contacts()->where('section', 'EVENT')->get();
				?>
				
				@if(count($contacts))
					<table class="table">
						@foreach($contacts as $contact)
							<tr>
								<td>{{ $contact->type }}</td>
								<td>{{ $contact->contact }}</td>
							</tr>
						@endforeach
					</table>
				@else
					No Contacts
				@endif
	            
	        </div>

	        <a href = "{{ route('admin.event.attendees', ['slug' => $event->slug]) }}" class="btn btn-info btn-block">VIEW ATTENDEES ({{ number_format($attendees) }})</a> 


	    </div>

	    <div class="col-md-8">
	        <div class="white-box">
	            
	            <table class="table color-table inverse-table">
	            	<tr>
	            		<th>Organizer</th>
	            		<td>{{ $event->user->name }}</td>
	            	</tr>

	            	<tr>
	            		<th>Event Name</th>
	            		<td>{{ $event->name }}</td>
	            	</tr>	

	            	<tr>
	            		<th>Date</th>
	            		<td>
	            			{{ defaultDate($event->start_date) == defaultDate($event->end_date) ? niceDate($event->start_date) : niceDate($event->start_date) . ' - ' . niceDate($event->end_date) }} 

                        	{{ ' (' . $event->start_time .' - '. $event->end_time . ')' }}
	            		</td>
	            	</tr>

	            	<tr>
	            		<th>Featured</th>
	            		<td>{{ $event->featured ? 'YES' : 'NO' }}</td>
	            	</tr>

	            	<tr>
	            		<th>Payment Method</th>
	            		<td>{{ $event->payment_method }}</td>
	            	</tr>

	            	<tr>
	            		<th>Include Weekends</th>
	            		<td>{{ $event->include_weekends ? 'YES' : 'NO' }}</td>
	            	</tr>

	            	<tr>
	            		<th>Invite Only</th>
	            		<td>{{ $event->invite_only ? 'YES' : 'NO' }}</td>
	            	</tr>

	            	<tr>
	            		<th>Venue</th>
	            		<td>{{ $event->venue }}</td>
	            	</tr>

	            	<tr>
	            		<th>Speaker Price</th>
	            		<td>
	            			{{ $event->speaker_price ? $options->currency . ' ' . number_format($event->speaker_price,2) : 'FREE' }}
	            		</td>
	            	</tr>

	            	<tr>
	            		<th>Delegate/Attendee Price</th>
	            		<td>
	            			{{ $event->delegate_price ? $options->currency . ' ' . number_format($event->delegate_price,2) : 'FREE' }}
	            		</td>
	            	</tr>

	            	<tr>
	            		<th>Showcaser/Exhibitor Price</th>
	            		<td>
	            			{{ $event->exhibitor_price ? $options->currency . ' ' . number_format($event->exhibitor_price,2) : 'FREE' }}
	            		</td>
	            	</tr>

	            	<tr>
	            		<th>Collect Revenue</th>
	            		<td>{{ $event->collect_revenue ? 'YES' : 'NO' }}</td>
	            	</tr>

	            	<tr>
	            		<th>Promote Event</th>
	            		<td>{{ $event->promote_event ? 'YES' : 'NO' }}</td>
	            	</tr>

	            	<tr>
	            		<th>Manage Attendees</th>
	            		<td>{{ $event->manage_attendees ? 'YES' : 'NO' }}</td>
	            	</tr>

	            	<tr>
	            		<th>MPESA (KES)</th>
	            		
	            		<td>
	            			<table>
	            				<tr>
	            					<th>Collected</th>
	            					<td>KES {{ number_format($event->mpesa_collected, 2) }}</td>
	            				</tr>

	            				<tr>
	            					<th>Commission</th>
	            					<td>KES {{ number_format($event->mpesa_commission, 2) }}</td>
	            				</tr>

	            				

	            				<tr>
	            					<th>Organizer Credit</th>
	            					<td>KES {{ number_format(($event->mpesa_collected - $event->mpesa_commission), 2) }}</td>
	            				</tr>
	            			</table>
	            		</td>
	            		
	            	</tr>

	            	<tr>
	            		<th>Paypal ({{ $options->paypal_currency }})</th>
	            		
	            		<td>
	            			<table>
	            				<tr>
	            					<th>Collected</th>
	            					<td>{{ $options->paypal_currency }} {{ number_format($event->paypal_collected, 2) }}</td>
	            				</tr>

	            				<tr>
	            					<th>Commission</th>
	            					<td>{{ $options->paypal_currency }} {{ number_format($event->paypal_commission, 2) }}</td>
	            				</tr>

	            				

	            				<tr>
	            					<th>Organizer Credit</th>
	            					<td>{{ $options->paypal_currency }} {{ number_format(($event->paypal_collected - $event->paypal_commission), 2) }}</td>
	            				</tr>
	            			</table>
	            		</td>
	            		
	            	</tr>

	            	<tr>
	            		<th>Money Collected by the Organizer?</th>
	            		<td>
	            			@if($event->paypal_collected || $event->mpesa_collected)
		            			@if($event->withdrawn)
									<p>YES</p>
									<p>Issued by: <strong>{{ $event->withdrawer->name }}</strong></p>
									<p>Date Issued: <strong>{{ niceDate($event->withdrawn_at) }}, {{ niceTime($event->withdrawn_at) }}</strong></p>
									<hr>
									
									<h5>PICKER INFO</h5>

									<p>Name: <strong>{{ $event->picker_name }}</strong></p>
									<p>Phone: <strong>{{ $event->picker_phone }}</strong></p>
									<p>ID Number: <strong>{{ $event->picker_id }}</strong></p>
									
		            			@else
									
									@if(!$event->closed)
										<button type = "button" data-toggle = "modal" data-target = "#close-event-modal" class="btn btn-warning">Withdraw Cash</button>
									@else
										<button type = "button" data-toggle = "modal" data-target = "#withdraw-cash-modal" class="btn btn-success">Withdraw Cash</button>
									@endif
		            			@endif
	            			@else
								<p>No Money Has Been Collected</p>
	            			@endif
	            		</td>
	            	</tr>

	            	

	            	

	            	
	            </table>

	            <h4 class="box-title">MAP</h4>
				
				@if($event->map)
					<div id="map">
						{!! $event->map !!}
					</div>
				@else

				@endif
	            

	        </div> 
	        

	    </div>
	</div>

	@if(!$event->withdrawn)
		@if(!$event->closed)
			@include('pages.admin.modals.close-event')
		@else
			@include('pages.admin.modals.withdraw-cash')
		@endif
	@endif

@endsection