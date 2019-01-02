@extends('layouts.user')

@section('title', $title)
@section('content')

    <section class="py-50">

        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <h4 class="text-center">{{ $title }}</h4><br>
                    @if(count($notifications))
                        @foreach($notifications as $notification)
                            <a href="{{ route('user.notification.get', ['id' => $notification->id]) }}">
                                <div class="custom-card mb-10">
                                    <div class="card-inner{{ $notification->read ? '' : ' active' }}">
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <img src="{{ profile_thumb($notification->sender->thumbnail) }}" alt="{{ $notification->sender->name }}" class = "full-width circle">
                                            </div>

                                            <div class="col-xs-10">
                                                
                                                {{ ucfirst($notification->message) }}   
                                                {{ $notification->sender->name }} <br>
                                                 

                                                 <small class="right">{{ $notification->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <h4 class="intro-text text-center py-50">NO NOTIFICATIONS</h4>
                    @endif
                </div>
            </div>
        </div>

    </section>

@endsection