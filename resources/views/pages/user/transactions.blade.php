@extends('layouts.user')

@section('title', $title)
@section('content')

    <section class="py-50">

        <div class="container">
            <div class="row">
                <div class="col-xs-10 col-xs-offset-1">
                    
                    @if(count($transactions))
                        <h3 class="text-center">TRANSACTIONS</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Transaction Code</th>
                                    <th>Event</th>
                                    <th>Amount</th>
                                    <th>Medium</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->completed_at->toDateTimeString() }}</td>
                                        <td>{{ $transaction->transaction_code }}</td>
                                        <td>
                                            {{ $transaction->event ? $transaction->event->name : 'N\A' }}
                                        </td>
                                        <td>{{$options->currency }} {{ number_format($transaction->amount,2) }}</td>
                                        <td>{{ $transaction->medium }}</td>
                                        <td>{{ $transaction->type }}</td>
                                        <td>{{ $transaction->status }}</td>
                                    </tr>    
                                @endforeach

                            </tbody>
                        </table>
                        
                    @else
                        <h4 class="intro-title text-center py-50">NO TRANSACTIONS</h4>
                    @endif
                </div>
            </div>
        </div>

    </section>

@endsection