@extends('layouts.user')

@section('title', $title)
@section('content')
    
    <section class="py-50">

        <div class="container">
            <form action="" method = "POST">
                @csrf
                
                <input type="hidden" name="attending_as" value = "{{ $attending_as }}">

                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="custom-card">
                            <div class="card-inner">
                                @if($event->invite_only)
                                    <h3>You are requesting to attend the event 
                                @else
                                    <h3>You have chosen to attend the event  
                                @endif
                                <strong>{{ $event->name }}</strong> as a(n) <strong>{{ attending_as($attending_as) }}</strong> 
                                    which 
                                    @if($price)
                                        costs <strong>KES ({{ number_format($price,2) }})</strong>
                                    @else
                                        is free of charge
                                    @endif
                                </h3>

                                <div class="input-field">
                                    <label for="topic">Topic (if you wish to present)</label>
                                    <textarea class = "materialize-textarea" name="topic" id="topic" rows="3"></textarea>
                                </div>

                                @if($logged_in)
                                    <button type = "submit" class="btn green waves-effect waves-light">PROCEED</button>
                                @else
                                    <a href = "#login" class="btn green waves-effect waves-light">PROCEED</a>
                                @endif
           
                                <a href = "{{ url()->previous() }}" class="btn red waves-effect waves-light right">CANCEL</a>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>

    </section>

    @if(!$logged_in)
        @include('pages.user.modals.login')
    @endif

@endsection