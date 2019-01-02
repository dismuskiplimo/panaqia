@extends('layouts.user')

@section('title', $title)
@section('content')
    
    

    <section class="py-50">

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="text-center text-upper">{{ $title }}</h3>
                    
                    @if($mine)
                       
                        <h4 class="text-center">[
                          @if($paid_paypal || $paid_mpesa)
                            MPESA: {{ $options->currency }} {{ number_format($paid_mpesa) }} <br>
                            PAYPAL: {{ $options->paypal_currency }} {{ number_format($paid_paypal) }}
                          @else
                            NO MONEY COLLECTED
                          @endif

                        ]</h4>

                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3 text-center">
                                <form action="" method="GET">
                                    @csrf

                                    <div class="input-field">
                                        <input type="text" name="" placeholder="ticket code" class="text-center quicksearch" required="">
                                    </div>

                                    <button type="button" class="btn waves-effect waves-light">SEARCH TICKET</button>
                                </form>
                            </div>
                        </div>
                        
                    @endif

                    <hr class="mb-20">
                </div>
            </div>

            <div class="row tiny">
                <div class="col-sm-6 match-height">
                    <h4>BOOKED ({{ number_format(count($paid_requests)) }})</h4>

                    @if(count($paid_requests))
                        <div class="grid">
                            @foreach($paid_requests as $request)
                                <a href="{{ route('user.other-profile.view', ['username' => $request->user->username]) }}" class="{{ $request->code }} grid-item blue-text">
                                    <div class="custom-card-border mb-10">
                                        <div class="card-inner">
                                            <div class="row">
                                                <div class="col-xs-2">
                                                    <img src="{{ profile_thumb($request->user->thumbnail) }}" alt="{{ $request->user->name }}" class = "responsive-img circle">
                                                </div>

                                                <div class="col-xs-10" style = "line-height:16px;">
                                                    {{ $request->user->name }} <span class="pull-right green-text"><strong>BOOKED</strong></span> <br>
                                                    From : <strong>{{ $request->user->country->name }}</strong><br>
                                                    Attending as : <strong>{{ attending_as($request->attending_as) }}</strong><br>
                                                    <small>
                                                        Booked {{ $request->created_at->diffForHumans() }}
                                                        @if($mine)
                                                            
                                                            <strong>
                                                                <span class="pull-right">Ticket Code : {{ $request->code }}</span>
                                                            </strong>

                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <h3>NO ONE HAS PAID</h3>
                    @endif
                </div>
                
                @if($mine)
                    <div class="col-sm-6 border-left match-height">
                        <h4>UNPAID ({{ number_format(count($unpaid_requests)) }})</h4>

                        @if(count($unpaid_requests))
                            @foreach($unpaid_requests as $request)
                                <a href="{{ route('user.other-profile.view', ['username' => $request->user->username]) }}" class="blue-text">
                                <div class="custom-card-border mb-10">
                                    <div class="card-inner">
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <img src="{{ profile_thumb($request->user->thumbnail) }}" alt="{{ $request->user->name }}" class = "responsive-img circle">
                                            </div>

                                            <div class="col-xs-10">
                                                {{ $request->user->name }} <span class="pull-right red-text"><strong>UNPAID</strong></span> <br>
                                                From : <strong>{{ $request->user->country->name }}</strong><br>
                                                Attending as : <strong>{{ attending_as($request->attending_as) }}</strong><br>

                                                <small>
                                                    {{ $request->created_at->diffForHumans() }}
                                                    @if($mine)
                                                        <strong>
                                                            <span class="pull-right">Amount Due : {{ $options->currency }} {{ number_format($request->amount_due,2) }}</span>
                                                        </strong>
                                                    @endif
                                                    
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            @endforeach
                        @else
                            <h3>NO UNPAID REQUESTS</h3>
                        @endif
                    </div>

                @endif
            </div>

        </div>

    </section>

@endsection