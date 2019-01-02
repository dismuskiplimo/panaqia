@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    
	    <div class="col-md-6 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats"> <i class="ti-money bg-megna"></i>
                    <div class="bodystate">
                        <h4>{{ $options->paypal_currency }} {{ number_format($options->account_balance_paypal,2) }}</h4> 
                        <span class="text-muted">Total Collected (Paypal)</span> </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats"> <i class="ti-money bg-info"></i>
                    <div class="bodystate">
                        <h4>KES {{ number_format($options->account_balance_mpesa,2) }}</h4> 
                        <span class="text-muted">Total Collected (MPESA)</span> </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats"> <i class="ti-receipt bg-inverse"></i>
                    <div class="bodystate">
                        <h4>{{ number_format($all_events_count) }}</h4> 
                        <span class="text-muted">All Events</span> </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats"> <i class="ti-receipt bg-success"></i>
                    <div class="bodystate">
                        <h4>{{ number_format($events_today_count) }}</h4> 
                        <span class="text-muted">Events Posted Today</span> </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats"> <i class="ti-receipt bg-warning"></i>
                    <div class="bodystate">
                        <h4>{{ number_format($events_this_month_count) }}</h4> 
                        <span class="text-muted">Events Posted This Month</span> </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats"> <i class="ti-receipt bg-primary"></i>
                    <div class="bodystate">
                        <h4>{{ number_format($events_this_year_count) }}</h4> 
                        <span class="text-muted">Events Posted This Year</span> </div>
                </div>
            </div>
        </div>

	</div>

	<div class="row">
		<div class="col-md-6 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats"> <i class="ti-user bg-inverse"></i>
                    <div class="bodystate">
                        <h4>{{ number_format($all_users_count) }}</h4> 
                        <span class="text-muted">All Users</span> </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats"> <i class="ti-user bg-success"></i>
                    <div class="bodystate">
                        <h4>{{ number_format($users_today_count) }}</h4> 
                        <span class="text-muted">Users Registered Today</span> </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats"> <i class="ti-user bg-warning"></i>
                    <div class="bodystate">
                        <h4>{{ number_format($users_this_month_count) }}</h4> 
                        <span class="text-muted">Users Registered This Month</span> </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats"> <i class="ti-user bg-primary"></i>
                    <div class="bodystate">
                        <h4>{{ number_format($users_this_year_count) }}</h4> 
                        <span class="text-muted">Users Registered This Year</span> </div>
                </div>
            </div>
        </div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="white-box">
				<h3 class="box-title">All Events ({{ number_format($all_events_count) }})</h3>
				<div style="height:450px;" id = "all_events"></div>	
			</div>
		</div>	
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="white-box">
				<h3 class="box-title">Events this Month ({{ number_format($events_this_month_count) }})</h3>
				<div style="height:450px;" id = "events_this_month"></div>	
			</div>
		</div>	
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="white-box">
				<h3 class="box-title">Events this Year ({{ number_format($events_this_year_count) }})</h3>
				<div style="height:450px;" id = "events_this_year"></div>	
			</div>
		</div>	
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="white-box">
				<h3 class="box-title">All Users ({{ number_format($all_users_count) }})</h3>
				<div style="height:450px;" id = "all_users"></div>	
			</div>
		</div>	
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="white-box">
				<h3 class="box-title">Users this Month ({{ number_format($users_this_month_count) }})</h3>
				<div style="height:450px;" id = "users_this_month"></div>	
			</div>
		</div>	
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="white-box">
				<h3 class="box-title">Users this Year ({{ number_format($users_this_year_count) }})</h3>
				<div style="height:450px;" id = "users_this_year"></div>	
			</div>
		</div>	
	</div>

	<script>
		new Morris.Bar({
			element: 'all_events',
			// Chart data records -- each entry in this array corresponds to a point on
			// the chart.
			data: [

				@if(count($all_events))
					@foreach($all_events as $year => $value)
						{ year: '{{ $year }}', value: {{ $value }} },
					@endforeach
				@else
					{ year: '{{ date('Y') }}', value: 0 }
				@endif
				
			],
			// The name of the data record attribute that contains x-values.
			xkey: 'year',
			// A list of names of data record attributes that contain y-values.
			ykeys: ['value'],
			// Labels for the ykeys -- will be displayed when you hover over the
			// chart.
			labels: ['Events']
		});
	</script>

	<script>
		new Morris.Bar({
			element: 'events_this_month',
			// Chart data records -- each entry in this array corresponds to a point on
			// the chart.
			data: [

				@if(count($events_this_month))
					<?php $cnt = 1?>
					@while($cnt <= $days_in_month)
						@foreach($events_this_month as $day => $value)
							@if($cnt == $day)
								{ day: '{{ $cnt }}', value: {{ $value }} },
							@else
								{ day: '{{ $cnt }}', value: 0 },
							@endif	
						@endforeach	

						<?php $cnt++; ?>
					@endwhile
					
				@else
					{ day: '{{ date('Y') }}', value: 0 }
				@endif
				
			],
			// The name of the data record attribute that contains x-values.
			xkey: 'day',
			// A list of names of data record attributes that contain y-values.
			ykeys: ['value'],
			// Labels for the ykeys -- will be displayed when you hover over the
			// chart.
			labels: ['Events']
		});
	</script>

	<script>
		new Morris.Bar({
			element: 'events_this_year',
			// Chart data records -- each entry in this array corresponds to a point on
			// the chart.
			data: [

				@if(count($events_this_year))
					
					<?php 
						$cnt = 0;
						$raw = [];

						foreach ($months as $month => $name) {
							$raw[$month] = 0;
						}

						foreach ($events_this_year as $month => $value) {
							$raw[$month-1] = $value;
						}

					?>

					@foreach($raw as $month => $value)
						
						{ month: '{{ $months[$month] }}', value: {{ $value }} },

						<?php $cnt++; ?>
												
					@endforeach
					
				@else
					{ month: '{{ date('Y') }}', value: 0 }
				@endif
				
			],
			// The name of the data record attribute that contains x-values.
			xkey: 'month',
			// A list of names of data record attributes that contain y-values.
			ykeys: ['value'],
			// Labels for the ykeys -- will be displayed when you hover over the
			// chart.
			labels: ['Events']
		});
	</script>

	<script>
		new Morris.Bar({
			element: 'all_users',
			// Chart data records -- each entry in this array corresponds to a point on
			// the chart.
			data: [

				@if(count($all_users))
					@foreach($all_users as $year => $value)
						{ year: '{{ $year }}', value: {{ $value }} },
					@endforeach
				@else
					{ year: '{{ date('Y') }}', value: 0 }
				@endif
				
			],
			// The name of the data record attribute that contains x-values.
			xkey: 'year',
			// A list of names of data record attributes that contain y-values.
			ykeys: ['value'],
			// Labels for the ykeys -- will be displayed when you hover over the
			// chart.
			labels: ['Events']
		});
	</script>

	<script>
		new Morris.Bar({
			element: 'users_this_month',
			// Chart data records -- each entry in this array corresponds to a point on
			// the chart.
			data: [

				@if(count($users_this_month))
					<?php $cnt = 1?>
					@while($cnt <= $days_in_month)
						@foreach($users_this_month as $day => $value)
							@if($cnt == $day)
								{ day: '{{ $cnt }}', value: {{ $value }} },
							@else
								{ day: '{{ $cnt }}', value: 0 },
							@endif	
						@endforeach	

						<?php $cnt++; ?>
					@endwhile
					
				@else
					{ day: '{{ date('Y') }}', value: 0 }
				@endif
				
			],
			// The name of the data record attribute that contains x-values.
			xkey: 'day',
			// A list of names of data record attributes that contain y-values.
			ykeys: ['value'],
			// Labels for the ykeys -- will be displayed when you hover over the
			// chart.
			labels: ['Users']
		});
	</script>


	<script>
		new Morris.Bar({
			element: 'users_this_year',
			// Chart data records -- each entry in this array corresponds to a point on
			// the chart.
			data: [

				@if(count($users_this_year))
					
					<?php 
						
						$raw = [];

						foreach ($months as $month => $name) {
							$raw[$month] = 0;
						}

						foreach ($users_this_year as $month => $value) {
							$raw[$month-1] = $value;
						}

					?>

					@foreach($raw as $month => $value)
						
						{ month: '{{ $months[$month] }}', value: {{ $value }} },

						
												
					@endforeach
					
				@else
					{ month: '{{ date('Y') }}', value: 0 }
				@endif
				
			],
			// The name of the data record attribute that contains x-values.
			xkey: 'month',
			// A list of names of data record attributes that contain y-values.
			ykeys: ['value'],
			// Labels for the ykeys -- will be displayed when you hover over the
			// chart.
			labels: ['Users']
		});
	</script>

	
@endsection