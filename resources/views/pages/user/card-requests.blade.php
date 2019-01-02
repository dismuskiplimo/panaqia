@extends('layouts.user')

@section('title', $title)
@section('content')
    
    

    <section class="py-50">

        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h4 class="mb-20">CARD REQUESTS ({{ number_format(count($card_requests)) }})</h4>    
                </div>

                <div class="col-sm-6 col-sm-offset-3">

                    @if(count($card_requests))
                        @foreach($card_requests as $card_request)
                            
                            
                            <div class="custom-card mb-10">
                                    <div class="card-inner">
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <a href="{{ route('user.other-profile.view', ['username' => $card_request->sender->username ]) }}">
                                                    <img src="{{ profile_thumb($card_request->sender-> thumbnail) }}" alt="{{ $card_request->sender->name }}" class="responsive-img circle mt-20">    
                                                </a>
                                            </div>

                                            <div class="col-xs-10">

                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <a href="{{ route('user.other-profile.view', ['username' => $card_request->sender->username ]) }}">{{ $card_request->sender->name }}</a> <br>
                                                        
                                                        @if($card_request->sender->position)
                                                            <small>{{ $card_request->sender->position }} &nbsp;</small>
                                                        @else
                                                            <small>&nbsp;</small>
                                                        @endif
                                                    </div>

                                                    <div class="col-xs-12">
                                                        <div class="row">
                                                            <div class="col-xs-6">
                                                                 <form action="{{ route('user.card.request.approve', ['id' => $card_request->id]) }}" method = "POST" class="">
                                                                    @csrf

                                                                    <button type = "submit" class="btn green" title = "Accept Request"><i class="fa fa-check"></i> ACCEPT</button>
                                                                    
                                                                </form>
                                                            </div>

                                                            <div class="col-xs-6">
                                                                <form action="{{ route('user.card.request.decline', ['id' => $card_request->id]) }}" method = "POST" class="">
                                                                    @csrf

                                                                    <button type = "submit" class="btn red right" title="Decline Request"><i class="fa fa-times"></i> DECLINE</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                


                                            </div>
                                        </div>
                                    </div>
                                </div>


                        @endforeach
                    @else
                        
                        <p>No Card Requests</p>
                    
                    @endif
                    
                </div>
            </div>
        </div>

    </section>

@endsection