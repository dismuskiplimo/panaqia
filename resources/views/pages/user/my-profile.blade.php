@extends('layouts.user')

@section('title', 'My Profile')
@section('content')

    <section class="py-50">

        <div class="container">
            <div class="row">
                
                <div class="col-sm-3">
                    <div class="custom-card">
                        <div class="card-inner text-center">
                            <span class="user-thumb">
                                <img src="{{ profile_pic($user->image) }}" alt="logo" class="img-responsive img-circle size-160 middle">


                                <span class="thumb-edit" title="Edit Profile Picture">
                                    

                                    <form action="{{ route('user.user-image.update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <button type="button" class="waves-effect waves-circle waves-light btn-floating btn-large blue file-button"> <i class="fa fa-picture-o"></i></button>

                                        <input type="file" name="image" class="hidden file-input">
                                    </form>
                                </span>
                            </span>

                            <h4 class="mt-30 text-center" >{{ $user->name }}</h4>
                        </div>
                    </div>
                    


                    

                    <div class="custom-card mt-20">
                        <div class="card-inner">
                            <div class="row">
                                <div class="col-sm-12">

                                    <h4><small>Company: </small> <br><br>
                                        <span  class="blue-text">
                                            {{ $user->name_of_company ? : 'Company' }}    
                                        </span>
                                    </h4>

                                    <hr class="">

                                    <h4><small>Position: </small> <br> <br>
                                        <span  class="blue-text">
                                            {{ $user->position ? : 'Position' }}
                                        </span>
                                    </h4>

                                    <hr class="">


                                    <h4><small>Country: </small> <br> <br>
                                        <span  class="blue-text">
                                            {{ $user->country ? $user->country->name : 'Country' }}
                                        </span>
                                        
                                    </h4>

                                    <div class="text-right full-width">
                                        <a href="#edit-event-profile" class="waves-effect waves-blue btn-custom blue"><i class="fa fa-edit"></i> Edit Profile</a>
                                    </div>    
                                
                                </div>
                            </div>
                              
                        </div>
                    </div>

                    <hr>

                    <p class="py-20">Profile Views <strong class="pull-right">{{ number_format($user->views) }}</strong></p>

                    
                </div>

                <div class="col-sm-6">

                    <div class="custom-card">
                        <div class="card-inner">
                            <div class="row">
                                <div class="col-xs-12">
                                    <h4>About:</h4>

                                    <p>{!! nl2br(clean($user->bio)) !!}</p>

                                    <div class="text-right">
                                        <a href="#edit-profile-bio" class="waves-effect waves-blue btn-custom blue-text"><i class="fa fa-plus"></i> Edit </a>
                                    </div>

                                    <hr class="py-20">

                                    <h4>Memberships:</h4>
                                    <div>
                                        @if(count($memberships))
                                            <ul class="ml-20">
                                                @foreach($memberships as $membership)
                                                    <li>
                                                        {{ $membership->name }} 

                                                        <span class="pull-right">
                                                            <a href="#edit-membership-{{$membership->id}}" class="btn-custom blue" title="Edit {{ $membership->name }}">
                                                                <i class="fa fa-edit"></i>
                                                            </a> &nbsp;

                                                            <a href="#delete-membership-{{$membership->id}}" class="btn-custom red" title="Delete {{ $membership->name }}">
                                                                <i class="fa fa-trash"></i>
                                                            </a>

                                                            @include('pages.user.modals.edit-membership')
                                                            @include('pages.user.modals.delete-membership')


                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>No Memberships</p>
                                        @endif

                                        <div class="text-right full-width">
                                            <a href="#add-membership" class="waves-effect waves-blue btn-custom blue-text"><i class="fa fa-plus"></i> Add Membership</a>
                                        </div>
                                    </div>

                                    <hr class="py-20">

                                    <h4>Awards:</h4>
                                    <div>
                                        @if(count($awards))
                                            <ul class="ml-20">
                                                @foreach($awards as $award)
                                                    <li>
                                                        {{ $award->name }}, {{ $award->year }}
                                                        
                                                        <span class="pull-right">
                                                            <a href="#edit-award-{{$award->id}}" class="btn-custom blue" title="Edit {{ $award->name }}">
                                                                <i class="fa fa-edit"></i>
                                                            </a> &nbsp;

                                                            <a href="#delete-award-{{$award->id}}" class="btn-custom red" title="Delete {{ $award->name }}">
                                                                <i class="fa fa-trash"></i>
                                                            </a>

                                                            @include('pages.user.modals.edit-award')
                                                            @include('pages.user.modals.delete-award')


                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>No Awards</p>
                                        @endif

                                        <div class="text-right full-width">
                                            <a href="#add-award" class="waves-effect waves-blue btn-custom blue-text"><i class="fa fa-plus"></i> Add Award</a>
                                        </div>
                                    </div>

                                    <hr class="py-20">

                                    <h4>Hobbies:</h4>
                                    <div>
                                        @if(count($hobbies))
                                            <ul class="ml-20">
                                                @foreach($hobbies as $hobby)
                                                    <li>
                                                        {{ $hobby->name }}

                                                        <span class="pull-right">
                                                            <a href="#edit-hobby-{{ $hobby->id }}" class="btn-custom blue" title="Edit {{ $hobby->name }}">
                                                                <i class="fa fa-edit"></i>
                                                            </a> &nbsp;

                                                            <a href="#delete-hobby-{{ $hobby->id }}" class="btn-custom red" title="Delete {{ $hobby->name }}">
                                                                <i class="fa fa-trash"></i>
                                                            </a>

                                                            @include('pages.user.modals.edit-hobby')
                                                            @include('pages.user.modals.delete-hobby')


                                                        </span>
                                                        
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>No Hobbies</p>
                                        @endif

                                        <div class="text-right full-width">
                                            <a href="#add-hobby" class="waves-effect waves-blue btn-custom blue-text"><i class="fa fa-plus"></i> Add Hobby</a>
                                        </div>
                                    </div>

                                    <hr class="py-20">

                                    <h4>Achievements:</h4>
                                    <div>
                                        @if(count($career_interests))
                                            <ul class="ml-20">
                                                @foreach($career_interests as $career_interest)
                                                    <li>
                                                        {{ $career_interest->name }}
                                                        
                                                        <span class="pull-right">
                                                            <a href="#edit-achievment-{{$career_interest->id}}" class="btn-custom blue" title="Edit {{ $career_interest->name }}">
                                                                <i class="fa fa-edit"></i>
                                                            </a> &nbsp;

                                                            <a href="#delete-achievment-{{$career_interest->id}}" class="btn-custom red" title="Delete {{ $career_interest->name }}">
                                                                <i class="fa fa-trash"></i>
                                                            </a>

                                                            @include('pages.user.modals.edit-career-interest')
                                                            @include('pages.user.modals.delete-career-interest')


                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>No Achievements</p>
                                        @endif

                                        <div class="text-right full-width">
                                            <a href="#add-achievment" class="waves-effect waves-blue btn-custom blue-text"><i class="fa fa-plus"></i> Add Achievement</a>
                                        </div>
                                    </div>

                                    <hr class="py-20">

                                    <h4>Education:</h4>
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
                                                    <th></th>
                                                    <th></th>
                                                    
                                                </thead>

                                                <tbody>
                                                    @foreach($user->education()->orderBy('created_at', 'ASC')->get() as $education)
                                                        <tr>
                                                            <td>{{ $education->start_year }}</td>
                                                            <td>{{ $education->end_year }}</td>
                                                            <td>{{ $education->school }}</td>
                                                            <td>{{ $education->level }}</td>
                                                            <td>{{ $education->field_of_study }}</td>
                                                            <td>{{ $education->grade }}</td>
                                                            <td>
                                                                <a href="#edit-education-{{ $education->id }}">
                                                                    <i class="fa fa-edit blue-text"></i>
                                                                </a>

                                                                @include('pages.user.modals.edit-education')
                                                            </td>

                                                            <td>
                                                                <a href="#delete-education-{{ $education->id }}">
                                                                    <i class="fa fa-trash red-text"></i>
                                                                </a>

                                                                @include('pages.user.modals.delete-education')
                                                            </td>
                                                            
                                                        </tr>
                                                        
                                                    @endforeach
                                                </tbody>
                                                
                                            </table>
                                        @else
                                            <p>No Education Info</p>
                                        @endif

                                        <div class="text-right full-width">
                                            <a href="#add-education" class="waves-effect waves-blue btn-custom blue-text"><i class="fa fa-plus"></i> Add Education</a>
                                        </div>
                                    </div>


                                    <hr class="py-20">

                                    <h4>Skills:</h4>
                                    <div>
                                        @if(count($user->skills))
                                            <ul class="ml-20">
                                                @foreach($user->skills as $skill)
                                                    <li>
                                                        {{ $skill->skill }}
                                                        
                                                        <span class="pull-right">
                                                            <a href="#edit-skill-{{$skill->id}}" class="btn-custom blue" title="Edit {{ $skill->skill }}">
                                                                <i class="fa fa-edit"></i>
                                                            </a> &nbsp;

                                                            <a href="#delete-skill-{{$skill->id}}" class="btn-custom red" title="Delete {{ $skill->skill }}">
                                                                <i class="fa fa-trash"></i>
                                                            </a>

                                                            @include('pages.user.modals.edit-skill')
                                                            @include('pages.user.modals.delete-skill')


                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>No Skills</p>
                                        @endif

                                        <div class="text-right full-width">
                                            <a href="#add-skill" class="waves-effect waves-blue btn-custom blue-text"><i class="fa fa-plus"></i> Add Skill</a>
                                        </div>
                                    </div>

                                    <hr class="py-20">

                                    <h4>Work Experience:</h4>
                                    <div>
                                        @if(count($user->work_experiences))
                                            <table class="table">
                                                <thead>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th>Company</th>
                                                    <th>Position</th>
                                                    <th></th>
                                                    
                                                    
                                                    
                                                </thead>

                                                <tbody>
                                                    @foreach($user->work_experiences as $work_experience)
                                                        <tr>
                                                            <td>{{ $work_experience->from_date }}</td>
                                                            <td>{{ $work_experience->to_date }}</td>
                                                            <td>{{ $work_experience->company }}</td>
                                                            <td>{{ $work_experience->position }}</td>
                                                            <td>
                                                                <span class="pull-right">
                                                                    <a href="#edit-work-experience-{{$work_experience->id}}" class="btn-custom blue" title="Edit Work Expereince">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a> &nbsp;

                                                                    <a href="#delete-work-experience-{{$work_experience->id}}" class="btn-custom red" title="Delete Work Experience">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>

                                                                    @include('pages.user.modals.edit-work-experience')
                                                                    @include('pages.user.modals.delete-work-experience')


                                                                </span>
                                                            </td>

                                                        </tr>
                                                        
                                                    @endforeach
                                                </tbody>
                                                
                                            </table>
                                            
                                        @else
                                            <p>No Work Experience</p>
                                        @endif

                                        <div class="text-right full-width">
                                            <a href="#add-work-experience" class="waves-effect waves-blue btn-custom blue-text"><i class="fa fa-plus"></i> Add Work Experience</a>
                                        </div>
                                    </div>

                                    <hr class="py-20">

                                    <h4>Reference:</h4>
                                    <div>
                                        @if(count($user->references))
                                            
                                            @foreach($user->references as $reference)
                                                <ul class="ml-20">
                                                    
                                                

                                                    
                                                    <li>
                                                        {{ $reference->name }}
                                                        
                                                        <span class="pull-right">
                                                            <a href="#edit-reference-{{$reference->id}}" class="btn-custom blue" title="Edit Reference">
                                                                <i class="fa fa-edit"></i>
                                                            </a> &nbsp;

                                                            <a href="#delete-reference-{{$reference->id}}" class="btn-custom red" title="Delete Reference">
                                                                <i class="fa fa-trash"></i>
                                                            </a>

                                                            @include('pages.user.modals.edit-reference')
                                                            @include('pages.user.modals.delete-reference')


                                                        </span>
                                                    </li>

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
                                            <p>No References</p>
                                        @endif

                                        <div class="text-right full-width">
                                            <a href="#add-reference" class="waves-effect waves-blue btn-custom blue-text"><i class="fa fa-plus"></i> Add Reference</a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="col-sm-3 col-sm-offset">
                    <div class="custom-card">
                        <div class="card-inner">
                          <h4>EVENTS ATTENDING</h4>
                            @if(count($sent_requests))
                                @foreach($sent_requests as $request)
                                    <?php $event = $request->event; ?>
                                    <div class="card">
                                        <div class="card-image">
                                            <a href="{{ route('event.view', ['slug'=>$event->slug]) }}">
                                                <img src="{{ thumbnail($event->thumbnail, 'event') }}" alt="">
                                            </a>

                                            <span class="event-price heverable">
                                                PAID
                                            </span>
                                                       
                                            </div>

                                            <div class="card-content match-height">
                                                @if($event->start_date->gte($today))
                                                    <small class="text-upper">{{ niceDate($event->start_date) }}</small>    
                                                @else
                                                    <small class="text-upper red-text">{{ niceDate($event->start_date) }} (ALREADY HAPPENED)</small>
                                                @endif
                                                
                                                <h4>
                                                    <strong class="text-upper">{{ words($event->name,4) }}</strong> <br>
                                                    <small class="mtn-20">{{ words($event->venue,4) }}</small>
                                                </h4>
                                                

                                               
                                                
                                                <div class="row"><hr></div>
                                                <p class="tiny">

                                                    @if(count($event->tags))
                                                        @foreach($event->tags as $tag)
                                                            <a href="{{ route('event.tags', ['tag' => $tag->name]) }}">#{{ $tag->name }}</a>  
                                                        @endforeach
                                                    @else
                                                        &nbsp;
                                                    @endif
                                                </p> 
                                            </div>
                                        </div>
                                @endforeach

                                <p><a href="{{ route('user.events.attending', ['username' => $user->username]) }}">See All</a></p>
                            @else
                                <p class="">No booked events</p>
                            @endif  
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    @include('pages.user.modals.add-event-contact')
    @include('pages.user.modals.edit-event-profile')
    @include('pages.user.modals.edit-profile-bio')

    @include('pages.user.modals.add-membership')
    @include('pages.user.modals.add-award')
    @include('pages.user.modals.add-user-contact')
    @include('pages.user.modals.add-hobby')
    @include('pages.user.modals.add-career-interest')
    @include('pages.user.modals.add-education')
    @include('pages.user.modals.add-reference')
    @include('pages.user.modals.add-work-experience')
    @include('pages.user.modals.add-skill')
    
    


@endsection