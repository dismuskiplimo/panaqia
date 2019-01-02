@extends('layouts.user')

@section('title', $title)
@section('content')
    
    

    <section class="py-50">

        <div class="container">
            <div class="col-md-3 text-center">
                <div class="custom-card">
                    <div class="card-inner">
                        <img src="{{ profile_pic($user->image) }}" alt="logo" class="img-responsive img-circle mb-20 size-160 middle">
                
                        <h4 class="text-center mt-30">{{ $user->name }}</h4>

                            
                        
                        @if(!$me)
                            @if(Auth::check())
                                @if($has_requested_me)
                                    <form action="{{ route('user.card.request.approve', ['id' => $has_requested_me->id]) }}" class="form-inline" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-custom btn-block green mb-10 text-capitalize">Approve Card Request</button>
                                    </form>
                                @endif
            
                                @if($request_sent)
                                    <button type="button" class="btn-custom btn-block green mb-10 text-capitalize"><i class="fa fa-check"></i> Card Requested</button>
                                @elseif($request_approved)
                                    <a href="#view-card" class="btn-custom btn-block orange mb-10 text-capitalize">View Card</a>
                                @elseif(!$has_requested_me)
                                    <form action="{{ route('user.card.request', ['username' => $user->username]) }}" class="form-inline" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-custom btn-block blue mb-10 text-capitalize">Request Card</button>
                                    </form>
                                @endif
                                
                                <a href="{{ route('user.message.new', ['recepient' => $user->username]) }}" class="btn-custom btn-block blue mb-20 text-capitalize"> Send Message </a>
                                
                            @else
                                <a href="#login" class="btn-custom btn-block blue mb-10 text-capitalize"> Send Message </a> 
                                <a href="#login" class="btn-custom btn-block blue mb-20 text-capitalize"> Request Card </a>
                            @endif


                        @endif

                    
                    </div>
                </div>
                      
                        
                <div class="custom-card mt-20 text-left">
                    <div class="card-inner">
                        <h4>Company:</h4>
                        <p class="blue-text">{{ $user->name_of_company ? : 'Not Specified' }}</p>

                        <h4>Position:</h4>
                        <p  class="blue-text">{{ $user->position ? : 'Not Specified' }}</p> 


                        

                        <h4>Country:</h4>
                        <p  class="blue-text">{{ $user->country ? $user->country->name : 'Country' }}</p>

                        

                        <hr>
                        
                        Profile views <strong><span class="pull-right">{{ number_format($user->views) }}</span></strong> 
                    </div>
                </div>

                               
            </div>

            <div class="col-md-6">
                <div class="custom-card">
                    <div class="card-inner">
                       
                        <h4>About:</h4>
                        <hr class = "mtn-10">
                        <p>{{ $user->bio ? : 'No Details' }}</p>
                            
                        
                        <br><h4>Memberships:</h4>
                        <hr class = "mtn-10">
                        
                        @if(count($memberships))
                            
                            <ul class="ml-20">
                                @foreach($memberships as $membership)
                                    <li>{{ $membership->name }}</li>
                                @endforeach
                            </ul>
                            

                        @else
                            <p class="ml-20">No Memberships Stated</p>
                        @endif

                        <h4>Education:</h4>
                        <hr class = "mtn-10">
                        <div>
                            @if(count($user->education))
                                <table class="table">
                                    <thead>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>School</th>
                                        <th>Level</th>
                                        <th>Field of Study</th>
                                        <th>Grade</th>
                                        
                                        
                                    </thead>

                                    <tbody>
                                        @foreach($user->education()->get() as $education)
                                            <tr>
                                                <td>{{ $education->start_year }}</td>
                                                <td>{{ $education->end_year }}</td>
                                                <td>{{ $education->school }}</td>
                                                <td>{{ $education->level }}</td>
                                                <td>{{ $education->field_of_study }}</td>
                                                <td>{{ $education->grade }}</td>
                                                
                                                
                                            </tr>
                                            
                                        @endforeach
                                    </tbody>
                                    
                                </table>
                            @else
                                <p class="ml-20">No Education Info</p>
                            @endif
                        </div>

                        <h4>Work Experience:</h4>
                        <hr class = "mtn-10">
                        <div>
                            @if(count($user->work_experiences))
                                <table class="table">
                                    <thead>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Company</th>
                                        <th>Position</th>
                                        
                                        
                                        
                                    </thead>

                                    <tbody>
                                        @foreach($user->work_experiences()->get() as $work_experience)
                                            <tr>
                                                <td>{{ $work_experience->from_date }}</td>
                                                <td>{{ $work_experience->to_date }}</td>
                                                <td>{{ $work_experience->company }}</td>
                                                <td>{{ $work_experience->position }}</td>
                                            </tr>
                                            
                                        @endforeach
                                    </tbody>
                                    
                                </table>
                            @else
                                <p class="ml-20">No Work Expereince Stated</p>
                            @endif
                        </div>
                        
                        <br><h4>Skills:</h4>
                        <hr class = "mtn-10">
                        
                        @if(count($user->skills))
                            <ul class="ml-20">
                                @foreach($user->skills as $skill)
                                    <li>{{ $skill->skill }}</li>
                                @endforeach
                            </ul>
                            

                        @else
                            <p class="ml-20">No Skills Stated</p>
                        @endif
                        
                        <br><h4>Awards:</h4>
                        <hr class = "mtn-10">
                        
                        @if(count($awards))
                            <ul class="ml-20">
                                @foreach($awards as $award)
                                    <li>{{ $award->name }}, {{ $award->year }}</li>
                                @endforeach
                            </ul>
                            

                        @else
                            <p class="ml-20">No Awards Stated</p>
                        @endif

                        <br><h4>Hobbies:</h4>
                        <hr class = "mtn-10">

                        @if(count($hobbies))                        
                            <ul class="ml-20">
                                @foreach($hobbies as $hobby)
                                    <li>{{ $hobby->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="ml-20">No Hobbies Stated</p>
                        @endif

                        <br><h4>Achievements:</h4>
                        <hr class = "mtn-10">

                        @if(count($career_interests))
                            
                            <ul class="ml-20">
                                @foreach($career_interests as $career_interest)
                                    <li>{{ $career_interest->name }}</li>
                                @endforeach
                            </ul>
                            
                        @else
                            <p class="ml-20">No Achievements Stated</p>
                        @endif

                        <br><h4>Reference:</h4>
                        <hr class = "mtn-10">

                        @if(count($user->references))                        
                            
                                     
                            @foreach($user->references as $reference)
                                <ul class="ml-20">
                                    <li><strong>Name :</strong> {{ $reference->name }}</li>
                                    <li><strong>Phone :</strong>{{ $reference->phone }}</li>
                                    <li><strong>Email :</strong>{{ $reference->email }}</li>
                                    <li><strong>Address :</strong>{{ $reference->address }}</li>
                                    <li><strong>Company :</strong>{{ $reference->company }}</li>
                                    <li><strong>Position :</strong>{{ $reference->position }}</li>
                                </ul>

                                <hr>
                                
                            @endforeach
                                     
                        @else
                            <p class="ml-20">No References Stated</p>
                        @endif

                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="custom-card tiny">
                    <div class="card-inner">
                        <h4>EVENTS ATTENDING</h4>
                        <hr class="mb-20">
                        @if(count($sent_requests))
                            @foreach($sent_requests as $request)
                                <?php $event = $request->event; ?>
                                <div class="card  mb-20">
                                    <div class="card-image">
                                        <a href="{{ route('event.view', ['slug'=>$event->slug]) }}">
                                            <img src="{{ thumbnail($event->thumbnail, 'event') }}" alt="">
                                        </a>

                                        <span class="event-price heverable">
                                            PAID
                                        </span>
                                                   
                                        </div>

                                        <div class="card-content match-height">
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
                            @endforeach

                            <a href="{{ route('user.events.attending', ['username' => $user->username]) }}">See All</a>
                        @else
                            <p class="">No booked events</p>
                        @endif  
                    </div>
                </div>
            </div>
        </div>

    </section>

    @if(!Auth::check())
        @include('pages.user.modals.login')
    @endif

    @if($request_approved)
        @include('pages.user.modals.view-card')
    @endif

@endsection