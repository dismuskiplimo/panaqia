@extends('layouts.user')

@section('title', $title)
@section('content')
    
    

    <section class="py-50">

        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h3>Events being attended by <a href="{{ route('user.other-profile.view', ['username' => $user->username]) }}">{{ $user->name }}</a></h3>
                </div>

                @if(count($sent_requests))
                    @foreach($sent_requests as $request)
                        <?php $event = $request->event;?>

                        <div class="col-sm-4 hoverable">
                            <div class="card">
                                <div class="card-image">
                                    <a href="{{ route('event.view', ['slug'=>$event->slug]) }}">
                                        <img src="{{ thumbnail($event->thumbnail, 'event') }}" alt="">
                                    </a>

                                    <span class="event-price heverable">
                                        BOOKED
                                       
                                    </span>
                                   
                                </div>

                                <div class="card-content match-height">
                                    <h4 class="mbn-5">
                                        <strong class="text-upper"> {{ characters($event->name,20) }}</strong> 
                                    </h4>

                                    <div class="mt-10">
            
                                        @if($event->start_date->gte($today))
                                            <small class="text-upper"><i class="fa fa-calendar"></i> {{ niceDate($event->start_date) }}</small>    
                                        @else
                                            <small class="text-upper red-text"><i class="fa fa-calendar"></i> {{ niceDate($event->start_date) }} (ALREADY HAPPENED)</small>
                                        @endif

                                    </div>
                                    
                                    <h4>
                                        
                                        <small class="mtn-20"><i class="fa fa-map-marker"></i> {{ words($event->venue,4) }}</small><br><br>
                                        
                                        <small class="mtn-20">ATTENDING 
                                            <span class="blue-text">
                                                {{ $event->requests()->where('paid', 1)->where('approved',1)->count() }}
                                            </span>
                                        </small><br><br>

                                        <small>
                                             <span class="pull-right">ID: {{ $event->id }}/{{ $event->created_at->year }}</span>
                                        </small>
                                    </h4>
                                    

                                   
                                    
                                    <div class="row"><hr></div>
                                    <p class="tiny">

                                        @if(count($event->tags))
                                            @foreach($event->tags as $tag)
                                                <a href="{{ route('event.tags', ['tag' => $tag->name]) }}" style="color: #2196F3;">#{{ $tag->name }}</a>  
                                            @endforeach
                                        @else
                                            &nbsp;
                                        @endif
                                    </p> 
                                </div>
                            </div>
                        </div>

                    @endforeach
                    <div class="col-xs-12">
                        {{ $sent_requests->links() }}
                    </div>
                @else
                    <div class="col-xs-12">No booked events</div>
                @endif
            </div>
        </div>

    </section>

@endsection