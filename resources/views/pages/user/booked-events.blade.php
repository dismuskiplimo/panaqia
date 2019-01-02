@extends('layouts.user')

@section('title', $title)
@section('content')
    

    <section class="py-50">

        <div class="container">
            <div class="row">
                @if(count($event_requests))
                    <h2 class="text-center">BOOKED EVENTS</h2><br>
                    @foreach($event_requests as $event_request)
                        <?php $event = $event_request->event; ?>

                        <div class="col-xs-4">
                            <div class="card">
                                <div class="card-image">
                                    <a href="{{ route('event.view', ['slug'=>$event->slug]) }}">
                                        <img src="{{ thumbnail($event->thumbnail, 'event') }}" alt="">
                                    </a>

                                    <span class="event-price heverable">
                                        @if($event_request->paid)
                                            
                                            <span class="green-text"><i class="fa fa-check"></i> BOOKED</span>
                                        @else
                                            <span class="orange-text"><i class="fa fa-info-circle"></i> PLEASE PAY {{ $options->currency }} {{ number_format($event_request->amount_due,2) }}</span>
                                        @endif
                                    </span>
                                               
                                            </div>

                                            <div class="card-content">
                                                <h4 class="mbn-5">
                                                    <strong class="text-upper"> 
                                                        {{ characters($event->name,20) }}
                                                    </strong> 
                                                </h4>
                                                
                                                <div class="mt-10">
            
                                                    @if($event->start_date->gte($today))
                                                        <small class="text-upper"><i class="fa fa-calendar"></i> {{ niceDate($event->start_date) }}</small>    
                                                    @else
                                                        <small class="text-upper red-text"><i class="fa fa-calendar"></i> {{ niceDate($event->start_date) }} (ALREADY HAPPENED)</small>
                                                    @endif

                                                </div>
                                                
                                                <h4>
                                                    
                                                    <small class="mtn-20"><i class="fa fa-map-marker"></i> &nbsp; {{ words($event->venue,4) }}</small><br><br>
                                                    
                                                    <small class="mtn-10"><i class="fa fa-users"></i> ATTENDING 
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
                    
                @else
                    <div class="col-xs-12">
                        <h4 class="intro-title text-center py-50">NO BOOKED EVENTS</h4>
                    </div>
                @endif
                
            </div>

            <div class="row">
                <div class="col-xs-12">
                    {{ $event_requests->links() }}
                </div>
            </div>
        </div>

    </section>

@endsection