@extends('layouts.user')

@section('title', $title)
@section('content')

    <section class="py-50">

        <div class="container">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<h3 class="text-center">PEOPLE WITH MY CARD ({{ number_format(count($card_requests)) }})</h3>

					@if(count($card_requests))
                        @foreach($card_requests as $card_request)
                            <div class="custom-card mb-10">
                                <div class="card-inner">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <a href="{{ route('user.other-profile.view', ['username' => $card_request->sender->username ]) }}">
                                                <img src="{{ profile_thumb($card_request->sender-> thumbnail) }}" alt="{{ $card_request->sender->name }}" class="responsive-img circle size-40">    
                                            </a>
                                            
                                        </div>

                                        <div class="col-xs-8">
                                            <a href="{{ route('user.other-profile.view', ['username' => $card_request->sender->username ]) }}">{{ $card_request->sender->name }}</a>
                                            
                                            
                                            {{-- @if($card_request->sender->position)
                                                <br><small>{{ $card_request->sender->position }} &nbsp;</small>
                                            @endif --}}
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    @else
                        <p>No one has your card</p>
                    @endif
                    
                </div>
				</div>
			</div>
        </div>

    </section>

@endsection