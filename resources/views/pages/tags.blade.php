@extends('layouts.user')

@section('title', $title)
@section('content')
    
    

    <section class="py-50">

        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    
                        <h4>Events matching the tag <strong class="blue-text">#{{ $tag }}</strong></h4>
                        <p class="blue-text"><strong>{{ number_format(count($event_tags)) }}</strong> Events found</p>
                    
                </div>
            </div>

            <div class="row">
                @if(count($event_tags))
                    @foreach($event_tags as $tag)
                        <div class="col-sm-4 hoverable">
                            <div class="card">
                                <div class="card-image">
                                    <a href="{{ route('event.view', ['slug'=>$tag->event->slug]) }}">
                                        <img src="{{ thumbnail($tag->event->thumbnail, 'event') }}" alt="">
                                    </a>

                                    <span class="event-price hoverable">
                            @if($tag->event->delegate_price)
                                {{ $options->currency }} {{ number_format($tag->event->delegate_price,2) }}
                            @else
                                FREE
                            @endif
                        </span>
                                   
                                </div>

                                <div class="card-content match-height">
                                    @if($tag->event->start_date->gte($today))
                                        <small class="text-upper">{{ niceDate($tag->event->start_date) }}</small>    
                                    @else
                                        <small class="text-upper red-text">{{ niceDate($tag->event->start_date) }} (ALREADY HAPPENED)</small>
                                    @endif
                                    
                                    <h4>
                                        <strong class="text-upper">{{ words($tag->event->name,4) }}</strong> <br>
                                        <small class="mtn-20">{{ words($tag->event->venue,4) }}</small>
                                    </h4>
                                    

                                    
                                    <div class="row"><hr></div>
                                    
                                    <p class="tiny">

                                        @if(count($tag->event->tags))
                                            @foreach($tag->event->tags as $t)
                                                <a href="{{ route('event.tags', ['tag' => $t->name]) }}">#{{ $t->name }}</a> 
                                            @endforeach
                                        @else
                                            &nbsp;
                                        @endif
                                    </p>

                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            {{$event_tags->links()}}        
                        </div>
                    </div>
                    
                @else
                    
                    

                    <p class="text-center">
                        <a href="{{ route('event.search') }}" class="btn orange waves-effect waves-light">Browse all events</a>    
                    </p>
                   
                @endif
            </div>
        </div>

    </section>

@endsection