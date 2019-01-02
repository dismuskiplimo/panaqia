@extends('layouts.user')

@section('title', $title)
@section('content')
    
    

    <section class="py-50">

        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <div class="custom-card">
                        <div class="card-inner">
                            <div>
                                 @if($event->banner)
                                    <img src="{{ image($event->banner) }}" alt="{{ $event->name }} Banner" class="full-width">
                                @else
                                    <img src="{{ my_asset('img/300x200.png') }}" alt="{{ $event->name }} Banner" class="full-width">
                                @endif

                                @if($mine)
                                    <span class="background-edit" title="Edit Event Banner" style = "right:30px">                                    
                                        <form action="{{ route('user.event-banner.update', ['id' => $event->id]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            
                                            <button type="button" class="waves-effect waves-circle waves-light btn-floating btn-large blue file-button"> <i class="fa fa-picture-o"></i></button>

                                            <input type="file" name="banner" class="hidden file-input">
                                        </form>
                                    </span>

                                    <span class="card-thumb" style="left:30px" title="Edit Event">
                                        <a href="#edit-event" class="waves-effect waves-circle waves-light btn-floating btn-large orange"><i class="fa fa-edit"></i></a>
                                    </span>
                                @endif

                                
                            </div>
                           
                            <div class="row">
                                <div class="col-xs-12 my-20">
                                    <div class="row">    
                                        <div class="col-xs-12">
                                            <div class="left">
                                                @if($logged_in)
                                                    <form action="{{ route('event.like', ['slug' => $event->slug]) }}" method = "POST">
                                                        @csrf

                                                        
                                                        @if($user->event_likes()->where('event_id', $event->id)->first())    
                                                            <button class="btn-custom green waves-effect waves-light" title="Unlike Event"><i class="fa fa-check"></i> liked</button>
                                                        @else
                                                            <button class="btn-flat waves-effect waves-teal" title="Like Event"><i class="fa fa-thumbs-up"></i></button>
                                                        @endif

                                                        
                                                    </form>

                                                    

                                                @else

                                                    <a href="#login" class="btn-flat waves-effect waves-teal"><i class="fa fa-thumbs-up"></i></a>

                                                @endif
                                            </div>
                                            

                                            <div class="left pl-10">
                                                <div class="mt-5">
                                                    {{ number_format(count($event->likes)) }} likes
                                                </div>
                                            </div>

                                            
                                        </div>  

                                        <div class="col-sm-12">
                                            <hr>
                                        </div>     
                                    </div>     
                                </div>

                                <div class="col-xs-12 text-upper">
                                    <h2 class="">{{ $event->name }}</h2>
                                    <h4 class="mtn-10"><strong>Event ID:</strong> {{ $event->id }}</h4>
                                    <h4 class="mtn-10"><strong>Category:</strong> {{ $event->category->name }}</h4>
                                    
                                </div>
                            </div>
                            
                            <div><span class="blue-text">
                                {{ defaultDate($event->start_date) == defaultDate($event->end_date) ? niceDate($event->start_date) : niceDate($event->start_date) . ' - ' . niceDate($event->end_date) }} 

                                ({{  $event->start_time .' - '. $event->end_time  }} HRS) <br>
                                </span>
                                
                                <span class="blue-text">
                                    Timezone : {{ $event->timezone ? $event->timezone->zone : '' }} ({{ $event->tz }})
                                </span>
                                
                                

                            </div>

                            <hr>


                            {!! clean(nl2br($event->description)) !!}

                            <h4 class="text-upper text-bold">Event Charges</h4>
                            <hr><br>

                            <h5>
                                Speaker  <span class="right">
                                    <strong>
                                        {{ $event->speaker_price ?  $options->currency . ' ' . number_format($event->speaker_price,2) : 'FREE' }}
                                        </strong>
                                    </span><br><br>
                                Delegate  <span class="right">
                                    <strong>
                                        {{ $event->delegate_price ? $options->currency . ' ' . number_format($event->delegate_price,2) : 'FREE' }}
                                        </strong>
                                    </span><br><br>
                                Showcaser/Exhibitor  <span class="right">
                                    <strong>
                                        {{ $event->exhibitor_price ? $options->currency . ' ' . number_format($event->exhibitor_price,2) : 'FREE' }}
                                        </strong>
                                    </span><br><br>
                            </h5>

                            @if(!$mine)
                                @if($event->invite_only)
                                    <h4 class="red-text"><i class="fa fa-info-circle"></i> This event is invite only, you need to send a request to the organizer</h4>
                                @endif
                            @endif

                            <p class="tex-center">
                                @if(!$mine && !$expired)
                                    @if($previously_booked)
                                        @if($previously_booked->paid)
                                            <span class="green-text"><i class="fa fa-check"></i> You have booked this event . Your Ticket code is <strong>{{ $previously_booked->code }}</strong></span>

                                            <a href = "{{ route('user.ticket.print', ['slug' => $event->slug, 'id' => $previously_booked->id]) }}" class="btn info"><i class="fa fa-print"></i> Print Ticket</a>
                                        @else
                                            @if(!$event->closed)
                                                @if(!$previously_booked->approved)
                                                    <span class="orange-text">Request sent, awaiting confirmation from organizer</span>
                                                @else
                                                    <a href="{{ route('user.checkout', ['id'=> $previously_booked->id, 'type' => 'ticket']) }}" class="btn orange waves-effect waves-light">PAY FOR THE EVENT</a>
                                                @endif
                                            @else
                                                <p class="text-warning">Event Closed, No more bookings</p>
                                            @endif
                                            
                                        @endif
                                        
                                    @else
                                        @if(!$event->closed)
                                            @if($event->invite_only)

                                                <a href="#attend-event" class="btn green waves-effect waves-light">SEND REQUEST</a>
                                            @else
                                                <a href="#attend-event" class="btn green waves-effect waves-light">ATTEND EVENT</a>
                                            @endif
                                        @else
                                             <p class="text-warning">Event Closed, No more bookings</p>
                                        @endif
                                        
                                    @endif
                                       
                                @elseif($expired && !$mine)
                                    <span class="orange-text">The Event Booking Date has already past</span>
                                @elseif(!$expired && $mine)
                                    @if($event->featured)
                                        <p class="green-text">This Event has been featured from <strong>{{ fullDate($event->featured_from) }} to {{ fullDate($event->featured_until) }}</strong></p>
                                    @else

                                        <hr>
                                        <p class="orange-text">
                                            Pay for the event to get featured i.e appear on our homepage slider. This is a good way to attract attendees. <br>
                                            <a href="#feature-event-modal" class="btn btn-primary">Get Featured</a>
                                        </p>
                                        
                                    @endif
                                @endif
                                
                            </p>

                            <p class="blue-text">
                                <a class="blue-text" href="{{ route('user.other-profile.view', ['username' => $event->user->username ]) }}">
                                    <i class="fa fa-eye"></i> View Organizer Profile
                                </a>

                                

                                @if($logged_in)
                                    @if(!$mine)
                                        <a href = "{{ route('user.message.new', ['recepient' => $event->user->username]) }}" class="pull-right blue-text"><i class="fa fa-envelope"></i> Message</a>
                                    @endif
                                @else
                                    <a href = "#login" class="pull-right blue-text"><i class="fa fa-envelope"></i> Message</a>
                                @endif
                            </p>

                            <p class="mtn-20">
                                <a class="blue-text" href="{{ route('user.event.attendees', ['slug' => $event->slug ]) }}">
                                    <span class="blue-text"><i class="fa fa-users"></i> View Attending</span>
                                </a> 
                            </p>      
                                
                            
                            
                            @if(!$mine)
                                @if(count($event->tags))
                                    <h4>Tags</h4>
                                    <p class="tiny"> 
                                        @foreach($event->tags as $tag)
                                            <a class="blue-text" href="{{ route('event.tags', ['tag' => $tag->name]) }}">#{{ $tag->name }}</a>   
                                        @endforeach
                                    </p>
                                @endif
                            @else
                                <h4>Tags</h4>
                                <table>
                                    @foreach($event->tags as $tag)
                                        <tr>
                                            <td>#{{ $tag->name }}</td>
                                            <td>
                                                <form class="form-inline" action="{{ route('user.delete-tag', ['id' => $tag->id]) }}" method = "POST">
                                                    @csrf

                                                    <button type="submit" class="btn-flat waves-effect waves-teal right" title="Delete Tag" type="submit"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                
                                <hr>

                                <form class="form-inline" action="{{  route('user.add-tag', ['slug' => $event->slug]) }}" method = "POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="input-field">
                                                <label for="">Add Tag</label>
                                                <input type="text" name="name" required="">
                                            </div>

                                            <button type="submit" class="btn-custom waves-effect waves-teal right blue"><i class="fa fa-plus"></i> Add tag</button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                            
                            @if(!$mine)
                                @if(count($event->social_links))
                                    <h4>Social Links</h4>
                                    <p class="tiny">
                                        @foreach($event->social_links as $link)
                                            <a class="blue-text" target="_blank" href="{{ $link->link }}"><i class="fa fa-{{ $link->icon }}"></i> {{ $link->name }}</a>   
                                        @endforeach                                    
                                    </p>
                                @endif
                            @else
                                <h4>Social Links</h4>
                                <table>
                                    @foreach($event->social_links as $link)
                                        <tr>
                                            <td>
                                                <a class="blue-text" target="_blank" href="{{ $link->link }}"><i class="fa fa-{{ $link->icon }}"></i> {{ $link->name }}</a>  
                                            </td>

                                            <td>
                                                <form class="form-inline" action="{{ route('social-link.delete', ['id' => $link->id]) }}" method = "POST">
                                                    @csrf

                                                    <button type="submit" class="btn-flat waves-effect waves-teal right" title="Delete Link" type="submit"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                
                                <hr>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <br><a href = "#add-social-link" type="submit" class="btn-custom waves-effect waves-teal right blue"><i class="fa fa-plus"></i> Add Social link</a>
                                    </div>
                                </div>
                            @endif

                            

                            @if(!$mine)
                                @if($event->sponsors()->where('type', 'SPONSOR')->count())
                                    <h4>Sponsors</h4>
                                    <div class="row text-center">
                                        @foreach($event->sponsors()->where('type', 'SPONSOR')->get() as $sponsor)
                                            <div class="col-sm-4 match-height tiny">
                                                <img src="{{ image($sponsor->logo, 'sponsor') }}" alt="" class="img-responsive">
                                                <span class="blue-text">{{ $sponsor->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                
                            @else
                                <h4>Sponsors</h4>
                                <div class="row">
                                    @foreach($event->sponsors()->where('type', 'SPONSOR')->get() as $sponsor)
                                        <div class="col-sm-4 match-height text-center tiny">
                                            <img src="{{ image($sponsor->logo, 'sponsor') }}" alt="" class="img-responsive">
                                            <span class="blue-text">{{ $sponsor->name }}</span>

                                            <form action="{{ route('event.sponsor.delete', ['id' => $sponsor->id]) }}" method = "POST" class="text-center">
                                                @csrf

                                                <button type="submit" class="btn-flat waves-effect waves-blue red-text" title="Delete {{ $sponsor->name }}" type="submit"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>

                                
                                
                                <hr>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <br><a href = "#add-sponsor" type="submit" class="btn-custom waves-effect waves-blue right blue"><i class="fa fa-plus"></i> Add Sponsor</a>
                                    </div>
                                </div>
                            @endif


                            

                            @if(!$mine)
                                @if($event->sponsors()->where('type', 'PARTNER')->count())
                                    <br><h4>Partners</h4>
                                    <div class="row text-center">
                                        @foreach($event->sponsors()->where('type', 'PARTNER')->get() as $sponsor)
                                            <div class="col-sm-4 match-height tiny">
                                                <img src="{{ image($sponsor->logo, 'sponsor') }}" alt="" class="img-responsive">
                                                <span class="blue-text">{{ $sponsor->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @else
                                <br><h4>Partners</h4>
                                <div class="row">
                                    @foreach($event->sponsors()->where('type', 'PARTNER')->get() as $sponsor)
                                        <div class="col-sm-4 match-height text-center tiny">
                                            <img src="{{ image($sponsor->logo, 'sponsor') }}" alt="" class="img-responsive">
                                            <span class="blue-text">{{ $sponsor->name }}</span>

                                            <form action="{{ route('event.sponsor.delete', ['id' => $sponsor->id]) }}" method = "POST" class="text-center">
                                                @csrf

                                                <button type="submit" class="btn-flat waves-effect waves-blue red-text" title="Delete {{ $sponsor->name }}" type="submit"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>

                                
                                
                                <hr>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <br><a href = "#add-partner" type="submit" class="btn-custom waves-effect waves-blue right blue"><i class="fa fa-plus"></i> Add Partner</a>
                                    </div>
                                </div>
                            @endif
  
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="custom-card">
                        <div class="card-inner">
                            <h2 class="text-bold">Attendees <span class="right">({{ number_format(count($attendees)) }})</span></h2>
                            <hr class="py-10">


                            <h4 class="text-bold">Speakers <span class="pull-right">{{ number_format(count($speakers)) }}</span></h4>
                                
                            @if(count($speakers))
                                @foreach($speakers as $event_request)
                                    
                                        <div class="custom-card-border">
                                            <div class="card-inner">
                                                <div class="row">
                                                <div class="col-xs-4">

                                                    <img src="{{ profile_thumb($event_request->user->thumbnail) }}" alt="{{ $event_request->user->name }}" class="responsive-img circle">
                                                </div>

                                                <div class="col-xs-8">
                                                    <div class="no-height">
                                                        <small class="no-height">
                                                            <span class = "blue-text">
                                                                <a class="blue-text" href="{{ route('user.other-profile.view', ['username' => $event_request->user->username ]) }}">
                                                                    <strong>{{ $event_request->user->name }}</strong> 
                                                                </a> <br>
                                                                <small class="mtn-10">{{$event_request->user->position }}</small> <br>
                                                            </span> 
                                                            
                                                            <span class = "orange-text">{{ words($event_request->topic, 4) }}</span> 
                                                            
                                                            <br><br>


                                                            <a class="blue-text" href="{{ route('user.other-profile.view', ['username' => $event_request->user->username ]) }}"><i class="fa fa-eye"></i> View profile</a> <br>
                                                            
                                                            @if($logged_in && $user->id != $event_request->user->id)
                                                                <a class="blue-text" href="{{ route('user.message.new', ['recepient' => $event_request->user->username]) }}"><i class="fa fa-envelope"></i> Message</a> <br>

                                                                @if($user->sent_requests()->where('to_id', $event_request->user->id)->where('approved', 0)->first())
                                                                    <div class="mt-10 green-text"><i class="fa fa-check"></i> Request sent</div>
                                                                
                                                                @elseif($user->card_requests()->where('from_id', $event_request->user->id)->where('approved', 0)->first())

                                                                    <?php
                                                                        $crd = $user->card_requests()->where('from_id', $event_request->user->id)->where('approved', 0)->first();
                                                                    ?>

                                                                    <form action="{{ route('user.card.request.approve', ['id' => $crd->id]) }}" method="POST" class="mt-10">
                                                                        @csrf
                                                                    
                                                                        <button type="submit" class = "btn-custom green"><i class="fa fa-newspaper-o"></i> Approve Card Request</button>
                                                                    </form>
                                                                    
                                                                @elseif(!$user->sent_requests()->where('to_id', $event_request->user->id)->where('approved', 1)->first() && !$user->card_requests()->where('from_id', $event_request->user->id)->where('approved', 1)->first())

                                                                    <form action="{{ route('user.card.request', ['username' => $event_request->user->username]) }}" method="POST" class="mt-10">
                                                                        @csrf
                                                                    
                                                                        <button type="submit" class = "btn-custom blue"><i class="fa fa-newspaper-o"></i> Request Card</button>
                                                                    </form>

                                                                @endif
                                                                
                                                            @endif

                                                            

                                                        </small>
                                                        
                                                    </div>
                                                    
                                                </div>

                                            </div>
                                        </div>
                                                                       
                                    </div>
                                @endforeach

                                <br><p class="text-center">
                                    <a class="blue-text" href="{{ route('user.event.attendees', ['slug' => $event->slug]) }}">See All</a>
                                </p>
                            @else
                                <p>No Speakers</p>
                            @endif

                            

                           
                            
                            
                            <hr class="py-10">

                            <h4 class="text-bold">Delegates <span class="pull-right">{{ number_format(count($delegates)) }}</span></h4>
                            
                            @if(count($delegates))
                                @foreach($delegates as $event_request)
                                    
                                        <div class="custom-card-border">
                                            <div class="card-inner">
                                                <div class="row">
                                                <div class="col-xs-4">

                                                    <img src="{{ profile_thumb($event_request->user->thumbnail) }}" alt="{{ $event_request->user->name }}" class="responsive-img circle">
                                                </div>

                                                <div class="col-xs-8">
                                                    <div class="no-height">
                                                        <small class="no-height">
                                                            <span class = "blue-text">
                                                                <a class="blue-text" href="{{ route('user.other-profile.view', ['username' => $event_request->user->username ]) }}">
                                                                    <strong>{{ $event_request->user->name }}</strong> 
                                                                </a> <br>
                                                                <small class="mtn-10">{{$event_request->user->position }}</small> <br>
                                                            </span> 
                                                            
                                                            <span class = "orange-text">{{ words($event_request->topic, 4) }}</span> 
                                                            
                                                            <br><br>


                                                            <a class="blue-text" href="{{ route('user.other-profile.view', ['username' => $event_request->user->username ]) }}"><i class="fa fa-eye"></i> View profile</a> <br>
                                                            
                                                            @if($logged_in && $user->id != $event_request->user->id)
                                                                <a class="blue-text" href="{{ route('user.message.new', ['recepient' => $event_request->user->username]) }}"><i class="fa fa-envelope"></i> Message</a> <br>
                                                                
                                                                @if($user->sent_requests()->where('to_id', $event_request->user->id)->where('approved', 0)->first())
                                                                    <div class="mt-10 green-text"><i class="fa fa-check"></i> Request sent</div>
                                                                @elseif($user->card_requests()->where('from_id', $event_request->user->id)->where('approved', 0)->first())

                                                                    <?php
                                                                        $crd = $user->card_requests()->where('from_id', $event_request->user->id)->where('approved', 0)->first();
                                                                    ?>

                                                                    <form action="{{ route('user.card.request.approve', ['id' => $crd->id]) }}" method="POST" class="mt-10">
                                                                        @csrf
                                                                    
                                                                        <button type="submit" class = "btn-custom green"><i class="fa fa-newspaper-o"></i> Approve Card Request</button>
                                                                    </form>
                                                                    
                                                                @elseif(!$user->sent_requests()->where('to_id', $event_request->user->id)->where('approved', 1)->first() && !$user->card_requests()->where('from_id', $event_request->user->id)->where('approved', 1)->first())

                                                                    <form action="{{ route('user.card.request', ['username' => $event_request->user->username]) }}" method="POST" class="mt-10">
                                                                        @csrf
                                                                    
                                                                        <button type="submit" class = "btn-custom blue"><i class="fa fa-newspaper-o"></i> Request Card</button>
                                                                    </form>

                                                                @endif
                                                                
                                                            @endif

                                                            

                                                        </small>
                                                        
                                                    </div>

                                                    
                                                    
                                                </div>

                                            </div>
                                        </div>
                                                                       
                                    </div>
                                @endforeach

                                <br><p class="text-center">
                                    <a class="blue-text" href="{{ route('user.event.attendees', ['slug' => $event->slug]) }}">See All</a>
                                </p>
                            @else
                                <p>No Delegates</p>
                            @endif

                            <hr class="py-10">

                            <h4 class="text-bold">Exhibitors <span class="pull-right">{{ number_format(count($exhibitors)) }}</span></h4>
                            @if(count($exhibitors))
                                @foreach($exhibitors as $event_request)
                                    
                                        <div class="custom-card-border">
                                            <div class="card-inner">
                                                <div class="row">
                                                <div class="col-xs-4">

                                                    <img src="{{ profile_thumb($event_request->user->thumbnail) }}" alt="{{ $event_request->user->name }}" class="responsive-img circle">
                                                </div>

                                                <div class="col-xs-8">
                                                    <div class="no-height">
                                                        <small class="no-height">
                                                            <span class = "blue-text">
                                                                <a class="blue-text" href="{{ route('user.other-profile.view', ['username' => $event_request->user->username ]) }}">
                                                                    <strong>{{ $event_request->user->name }}</strong> 
                                                                </a> <br>
                                                                <small class="mtn-10">{{$event_request->user->position }}</small> <br>
                                                            </span> 
                                                            
                                                            <span class = "orange-text">{{ words($event_request->topic, 4) }}</span> 
                                                            
                                                            <br><br>


                                                            <a class="blue-text" href="{{ route('user.other-profile.view', ['username' => $event_request->user->username ]) }}"><i class="fa fa-eye"></i> View profile</a> <br>
                                                            
                                                            @if($logged_in && $user->id != $event_request->user->id)
                                                                <a class="blue-text" href="{{ route('user.message.new', ['recepient' => $event_request->user->username]) }}"><i class="fa fa-envelope"></i> Message</a> <br>
                                                                

                                                                @if($user->sent_requests()->where('to_id', $event_request->user->id)->where('approved', 0)->first())
                                                                    <div class="mt-10 green-text"><i class="fa fa-check"></i> Request sent</div>
                                                                @elseif($user->card_requests()->where('from_id', $event_request->user->id)->where('approved', 0)->first())

                                                                    <?php
                                                                        $crd = $user->card_requests()->where('from_id', $event_request->user->id)->where('approved', 0)->first();
                                                                    ?>

                                                                    <form action="{{ route('user.card.request.approve', ['id' => $crd->id]) }}" method="POST" class="mt-10">
                                                                        @csrf
                                                                    
                                                                        <button type="submit" class = "btn-custom green"><i class="fa fa-newspaper-o"></i> Approve Card Request</button>
                                                                    </form>
                                                                    
                                                                @elseif(!$user->sent_requests()->where('to_id', $event_request->user->id)->where('approved', 1)->first() && !$user->card_requests()->where('from_id', $event_request->user->id)->where('approved', 1)->first())

                                                                    <form action="{{ route('user.card.request', ['username' => $event_request->user->username]) }}" method="POST" class="mt-10">
                                                                        @csrf
                                                                    
                                                                        <button type="submit" class = "btn-custom blue"><i class="fa fa-newspaper-o"></i> Request Card</button>
                                                                    </form>

                                                                @endif
                                                                
                                                            @endif

                                                            

                                                        </small>
                                                        
                                                    </div>
                                                    
                                                </div>

                                            </div>
                                        </div>
                                                                       
                                    </div>
                                @endforeach

                                <br><p class="text-center">
                                    <a class="blue-text" href="{{ route('user.event.attendees', ['slug' => $event->slug]) }}">See All</a>
                                </p>
                            @else
                                <p>No Exhibitors</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    
                    <div class="custom-card mb-10">
                        <div class="card-inner">
                            <div class="row">
                                <div class="col-xs-12">
                                    <h2 class="text-bold">Discussion ({{ number_format(count($discussions)) }})</h2>
                                    <div class="discussions-wrapper">
                                        <div class="discussions">
                                            @if(count($discussions))
                                                @foreach($discussions as $discussion)
                                                    <div class="discussion">
                                                        <img src="{{ profile_thumb($discussion->user->thumbnail) }}" class="responsive-img circle" alt="im">
                                                        <span>
                                                            <strong><a class="blue-text" href="{{ route('user.other-profile.view',['username' => $discussion->user->username]) }}">{{ $discussion->user->name }}</a></strong><br> <br>
                                                            
                                                            
                                                            {{ $discussion->message }} <br>

                                                            <span class="right"><strong>{{ $discussion->created_at->diffForHumans() }}</strong></span>   
                                                        </span>
                                                        
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="discussion text-center">
                                                    @if($logged_in)
                                                        Be the first to comment
                                                    @else
                                                        No comments yet
                                                    @endif
                                                </div>
                                            @endif

        
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>


                     @if($logged_in)
                        <div class="custom-card mt-20">
                         <div class="card-inner">
                            <div class="row">
                                <div class="col-xs-12">
                                    <form action="{{ route('event.comment', ['slug' => $event->slug]) }}" method="POST" id = "discussion-form">
                                         @csrf
                                        
                                        <div class="input-field">
                                            <label for="message-content">Comment</label>
                                            <textarea type="text" name="message" id="message-content" class="materialize-textarea"></textarea>
                                        </div>

                                        <button type="submit" class="btn waves-effect round waves-light blue right"><i class="material-icons" style="width:10px; height:10px;">send</i></button>

                                     </form>       
                                </div>
                                
                            </div>
                             
                         </div>
                        </div>
                    @endif
                     
                    

                    
                </div>
            </div>

            @if($event->map)
                <div class="row mt-20">
                    <div class="col-xs-12">
                        <h4>Location</h4>
                            <div id="#map">
                                {!! $event->map !!}    
                            </div>
                    </div>
                </div>

            @endif

            


        </div>

    </section>

    <input type="hidden" id = "discussion-route" value = "{{ route('user.event.discussion', ['slug' => $event->slug]) }}">
    <input type="hidden" id = "discussion-count" value = "{{ count($event->discussions) }}">

    

    @if(!Auth::check())
        @include('pages.user.modals.login')
    @endif


    @if(!$mine || !$expired)
        @include('pages.user.modals.attend-event')
    @endif

    @if($mine)
        @include('pages.user.modals.edit-event')
        @include('pages.user.modals.add-link')
        @include('pages.user.modals.add-sponsor')
        @include('pages.user.modals.add-partner')
    @endif

    @if(!$expired && $mine && !$event->featured)
         @include('pages.user.modals.feature-event')
    @endif

@endsection