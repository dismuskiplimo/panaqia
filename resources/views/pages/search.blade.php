@extends('layouts.user')

@section('title', $title)
@section('content')
    
    

    <section class="py-50">

        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    @if($request->has('search') && !empty($request->search))
                        <h4>Search results for <strong class="blue-text">{{ $request->search }}</strong></h4>
                        <p class="blue-text"><strong>{{ number_format(count($events)) }}</strong> Events found</p>
                    @endif
                </div>
            </div>

            <div class="row">
                @if(count($events))
                    @foreach($events as $event)
                        @include('pages.user.event-card')
                    @endforeach
                    
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            {{$events->links()}}        
                        </div>
                    </div>
                    
                @else
                    @if(!$request->has('search'))
                        <h2 class = "text-center intro-title py-50">NO EVENTS</h2>
                    @else
                        <p class="text-center">
                            <a href="{{ route('event.search') }}" class="btn orange waves-effect waves-light">Browse all events</a>    
                        </p>
                        
                    @endif
                @endif
            </div>
        </div>

    </section>

@endsection