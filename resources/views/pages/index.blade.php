@extends('layouts.user')

@section('title', $title)
@section('content')


    <div class="full-width">
        
            <div id="featured-carousel" class="carousel slide" data-ride="carousel" data-pause="hover">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#featured-carousel" data-slide-to="0" class="active"></li>
                    @if(count($featured_events))
                        <?php $cnt = 0; ?>
                        @foreach($featured_events as $event)
                            <?php $cnt += 1;?>
                            <li data-target="#featured-carousel" data-slide-to="{{ $cnt }}"></li>
                        @endforeach
                    @endif
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">  
                        <img src="{{ my_asset('img/panaqia-bg.jpg') }}" alt="Los Angeles">

                        <div class="centered text-center">
                            <img src="{{ my_asset('img/blue-logo.png') }}" alt="" class="size-100 mt-50 mb-20">

                            <h1 class="intro-title text-uppercase white-text mb-30">Panaqia</h1>

                            <h3 class="white-text text-2x text-bold">Go, Meet, & Discover</h3>

                            <div class="row">
                               
                                <form action="{{ route('event.search') }}" method = "GET" class = "text-center">
                                    <div class="input-field">  
                                        <input type="text" name="search" id="search" class="text-center white-text" placeholder="Event name or event ID">
                                    </div>

                                    <button class="btn waves-effect waves-light btn-large" type="submit"><i class="fa fa-search"></i> SEARCH EVENT</button>
                                </form>

                                
                                
                            </div>
                            
                        </div>
                    </div>

                    @if(count($featured_events))
                        @foreach($featured_events as $event)
                            <div class="item">
                                <img src="{{ featured_image($event->featured_image) }}" alt="{{ $event->name }}">

                                <div class="centered text-center">
                                    <h2 class="big-text">{{ words($event->name, 10) }}</h2>
                                    <h3 class="big-text">
                                        {{ defaultDate($event->start_date) == defaultDate($event->end_date) ? niceDate($event->start_date) : niceDate($event->start_date) . ' - ' . niceDate($event->end_date) }} 

                                        {!! ' <br> ' . $event->start_time .' - '. $event->end_time !!}
                                    </h3>

                                    <h4 class="big-text">{{ words($event->venue, 10) }}</h4><br>

                                    <h3 class="big-text">
                                        {{ $event->delegate_price ? $options->currency . ' ' . number_format($event->delegate_price,2) : 'FREE' }}
                                    </h3><br>

                                    <p><a href="{{ route('event.view', ['slug' => $event->slug]) }}" class="btn red">VIEW EVENT</a></p>

                                </div>
                            </div>
                        @endforeach
                    @endif

                    

                    
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#featured-carousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#featured-carousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        
    </div>

@endsection