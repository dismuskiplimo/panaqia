@extends('layouts.user')

@section('title', $title)
@section('content')
    
    

    <section class="py-50">

        <div class="container">
            <div class="row">
                <a href="{{ route('user.event.add') }}" class="btn waves-effect waves-light blue btn-large" title="Create Event" style="text-transform: initial;">Create Event</a>    
            </div>

            <div class="row pb-50">
                <div class="col-sm-6 col-sm-offset-3">
                    <form action="" method = "GET">
                        
                        
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="input-field">
                                    <label for="search-form">Search Events</label>
                                    <input type="text" name="search" id="search-form" value="{{ $request->search }}">
                                </div>    
                            </div>

                            
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    @if(count($events))
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="blue-text">{{ number_format(count($events)) }} events found</p>
                            </div> 

                            @foreach($events as $event)
                                
                                @include('pages.user.event-card')

                            @endforeach

                        </div>

                        <div class="row">
                            <div class="col-xs-12 text-center">
                                {{$events->links()}}        
                            </div>
                        </div>

                    @else
                        @if($request->search)
                            <p class="text-center">No events found for <strong>{{ $request->search }}</strong></p>
                        @else
                            <p class="text-center intro-title py-50">NO EVENTS</p>
                        @endif
                        
                    @endif
                </div>
            </div>
        </div>

    </section>

@endsection