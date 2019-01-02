@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
				<h4 class="box-title">@yield('title') ({{ number_format($transactions->total()) }})</h4>

				@if(count($transactions))
					<table class="table color-table inverse-table">
						<thead>
							<tr>
								<th>Transaction Code</th>
								<th>Type</th>
								<th>Date</th>
								<th>Amount</th>
								<th>User</th>
								<th>Event</th>
								<th>Medium</th>
								<th>Status</th>
							</tr>
						</thead>
					

						<tbody>
							@foreach($transactions as $transaction)
								<tr>
									<td>{{ $transaction->transaction_code }}</td>
									<td>{{ $transaction->type }}</td>
									<td>{{ fullDate($transaction->created_at) }}</td>
									<td>{{ $transaction->currency_code }} {{ number_format($transaction->amount,2) }}</td>
									<td><a href="{{ route('admin.user', ['username' => $transaction->user->username]) }}">{{ $transaction->user->name }}</a></td>
									<td><a href="{{ route('admin.event', ['slug' => $transaction->event->slug]) }}">{{ $transaction->event->name }}</a></td>
									<td>{{ $transaction->medium }}</td>
									<td>{{ $transaction->status }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>

					{{ $transactions->links() }}
				@else
					<p>No transactions yet</p>
				@endif
	        </div> 
	 	</div>
	</div>
@endsection