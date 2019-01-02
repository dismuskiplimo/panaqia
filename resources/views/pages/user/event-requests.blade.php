@extends('layouts.user')

@section('title', $title)
@section('content')
    

    <section class="py-50">

        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    @if(count($event_requests))
                        @foreach($event_requests as $request)
                            <div class="custom-card-hover">
                                <div class="card-inner">
                                    <div class="row">
                                        <div class="col-xs-2">
                                            <a href="{{ route('user.other-profile.view', ['username' => $request->user->username]) }}">
                                                <img src="{{ profile_thumb($request->user->thumbnail) }}" alt="{{ $request->user->name }}" class="responsive-img circle">
                                            </a>
                                            
                                        </div>

                                        <div class="col-xs-10">
                                            <a href="{{ route('user.other-profile.view', ['username' => $request->user->username]) }}">
                                                <strong>{{ $request->user->name }}</strong> 
                                            </a>

                                            wants to attend your event 
                                            
                                            <a href="{{ route('event.view', ['slug' => $request->event->slug]) }}">
                                                <strong>{{ $request->event->name }}</strong>
                                            </a> 

                                            as a(n) <strong>{{ $request->attending_as }}</strong>
                                            

                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <form action="{{ route('user.event.approve', ['id' => $request->id]) }}" method = "POST">
                                                        @csrf

                                                        <button class="btn green waves-effect waves-light"><i class="fa fa-check"></i> APPROVE</button>
                                                    </form>    
                                                </div>
                                                
                                                <div class="col-xs-6">
                                                    <form action="{{ route('user.event.reject', ['id' => $request->id]) }}" method = "POST">
                                                        @csrf

                                                        <button class="btn red waves-effect waves-light right"><i class="fa fa-times"></i> REJECT</button>
                                                    </form> 
                                                </div>
                                                
                                            </div>
                                        </div>    
                                    </div>
                                    
                                </div>
                            </div>
                        @endforeach
                    @else

                    <h4 class="intro-title py-50 text-center">NO REQUESTS</h4>   
                        
                        
                    @endif
                </div>
            </div>
        </div>

    </section>

@endsection