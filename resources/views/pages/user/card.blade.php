@extends('layouts.user')

@section('title', $title)
@section('content')
    
    

    <section class="py-50">

        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="custom-card">
                        <div class="card-inner">
                        <h3 class="blue-text">My card requests ({{ number_format($card_requests_count) }})</h3>

                        <div class="card-requests">
                            @if(count($card_requests))
                                @foreach($card_requests as $card_request)
                                    <div class="custom-card-grey mb-10 tiny">
                                        <div class="card-inner">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <a href="{{ route('user.other-profile.view', ['username' => $card_request->sender->username ]) }}">
                                                        <img src="{{ profile_thumb($card_request->sender-> thumbnail) }}" alt="{{ $card_request->sender->name }}" class="responsive-img circle mt-5">    
                                                    </a>
                                                </div>

                                                <div class="col-xs-8">

                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <a href="{{ route('user.other-profile.view', ['username' => $card_request->sender->username ]) }}" class="blue-text">{{ characters($card_request->sender->name,12) }}</a>
                                                            
                                                            @if($card_request->sender->position)
                                                                <br><small>{{ $card_request->sender->position }} &nbsp;</small>
                                                            @endif
                                                        </div>

                                                        <div class="col-xs-12">
                                                            <div class="row">
                                                                <div class="col-xs-6">
                                                                     <form action="{{ route('user.card.request.approve', ['id' => $card_request->id]) }}" method = "POST" class="">
                                                                        @csrf

                                                                        <button type = "submit" class="btn green" title = "Accept Request"><i class="fa fa-check"></i></button>
                                                                        
                                                                    </form>
                                                                </div>

                                                                <div class="col-xs-6">
                                                                    <form action="{{ route('user.card.request.decline', ['id' => $card_request->id]) }}" method = "POST" class="">
                                                                        @csrf

                                                                        <button type = "submit" class="btn red" title="Decline Request"><i class="fa fa-times"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                @endforeach

                                @if($card_requests_count > 10)
                                    <p class = "text-center">
                                        <a href="{{ route('user.card-requests') }}"  class="btn orange mt-10">See all</a>
                                    </p>
                                @endif
                            @else
                                <p>No Card Requests</p>
                            @endif
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-image">
                            @if($card->background)
                                <img src="{{ image($card->background) }}" alt="">
                            @else
                                <img src="{{ my_asset('img/300x200.png') }}" alt="">
                            @endif
                            
                            <span class="card-thumb size-160" style="margin-top:20px">
                                @if($card->thumbnail)
                                    <img src="{{ image($card->thumbnail) }}" class = "circle-img responsive-img dark-drop-shadow" alt="">
                                @else
                                    <img src="{{ my_asset('img/default-user.png') }}" alt="logo" class="img-responsive">
                                @endif      

                                <span class="thumb-edit" title="Upload Image">
                                    

                                    <form action="{{ route('user.card-thumbnail.update', ['id' => $card->id]) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <button type="button" class="waves-effect waves-circle waves-light btn-floating btn-large blue file-button"> <i class="fa fa-picture-o"></i></button>

                                        <input type="file" name="image" class="hidden file-input">
                                    </form>
                                </span>
                            </span>

                            <span class="background-edit" title="Upload Card">                                    
                                <form action="{{ route('user.card-background.update', ['id' => $card->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <button type="button" class="waves-effect waves-circle waves-light btn-floating btn-large blue file-button"> <i class="fa fa-picture-o"></i></button>

                                    <input type="file" name="image" class="hidden file-input">
                                </form>
                            </span>

                            <span class="card-title">{{ $user->name }}</span>

                            {{-- <span class="card-edit">
                                <a href="#edit-card-modal" class="waves-effect waves-circle waves-light btn-floating btn-large green" title = "Edit Contact Links">
                                    <i class="fa fa-edit"></i>
                                </a>
                                
                            </span> --}}

                       </div>

                        <div class="card-content">
                            {{-- <h4>{{ $card->company ? : 'Company' }}  <br>
                                <small>{{ $card->position? : 'Position' }}</small>
                                
                            </h4>
                            

                            <h4>About <br>
                                <small>
                                    {{ $card->description ? : 'No data' }}
                                </small>
                            </h4> --}}

                            <h4> 
                                <small>
                                    @if(count($card_contacts))
                                        <br>
                                        <table class = "table table-condensed">
                                            @foreach($card_contacts as $contact)
                                                <tr>
                                                    <td>
                                                        @if($contact->type == 'PHONE')
                                                            <i class="fa fa-phone"></i> 
                                                            Phone

                                                        @elseif($contact->type == 'MOBILE')
                                                            <i class="fa fa-mobile-phone"></i> Mobile 
                                                        @elseif($contact->type == 'EMAIL')
                                                            
                                                            <i class="fa fa-envelope"></i> 
                                                            Email  
                                                            
                                                        @elseif($contact->type == 'WEBSITE')
                                                            
                                                            <i class="fa fa-globe"></i> 
                                                            Website
                                                            
                                                        @elseif($contact->type == 'ADDRESS')
                                                            <i class="fa fa-envelope-o"></i> 
                                                            Address 
                                                        @elseif($contact->type == 'FACEBOOK')
                                                            
                                                            <i class="fa fa-facebook-square"></i> Facebook
                                                           
                                                            
                                                        @elseif($contact->type == 'TWITTER')
                                                            
                                                            <i class="fa fa-twitter-square"></i> Twitter
                                                            
                                                            
                                                        @elseif($contact->type == 'LINKEDIN')
                                                            
                                                            <i class="fa fa-linkedin-square"></i> LinkedIn
                                                            
                                                        @endif
                                                        
                                                    </td>
                                                    
                                                    <td>
                                                        @if($contact->type == 'PHONE')
                                                             
                                                            {{ $contact->contact }}

                                                        @elseif($contact->type == 'MOBILE')
                                                             {{ $contact->contact }} 
                                                        @elseif($contact->type == 'EMAIL')
                                                            <a href="mailto:{{ $contact->contact }}" style="text-transform:lowercase; color: #2196F3;">
                                                                 
                                                            {{ $contact->contact }}
                                                            </a>
                                                            
                                                        @elseif($contact->type == 'WEBSITE')
                                                            <a href="{{ $contact->contact }}" target="_blank" style="text-transform:lowercase; color: #2196F3;">
                                                               
                                                                {{ $contact->contact }}
                                                            </a>
                                                            
                                                        @elseif($contact->type == 'ADDRESS')
                                                            {{ $contact->contact }} 
                                                        @elseif($contact->type == 'FACEBOOK')
                                                            <a href="{{ $contact->contact }}" target="_blank" style="text-transform:lowercase; color: #2196F3;">
                                                                {{ $contact->contact }}
                                                            </a>
                                                            
                                                        @elseif($contact->type == 'TWITTER')
                                                            <a href="{{ $contact->contact }}" target="_blank" style="text-transform:lowercase; color: #2196F3;">
                                                                {{ $contact->contact }}
                                                            </a>
                                                            
                                                        @elseif($contact->type == 'LINKEDIN')
                                                            <a href="{{ $contact->contact }}" target="_blank" style="text-transform:lowercase; color: #2196F3;">
                                                                {{ $contact->contact }}
                                                            </a>
                                                            
                                                        @endif
                                                        
                                                    </td>

                                                    <td class="text-right">
                                                        <form action="{{ route('user.contact.delete', ['id'=>$contact->id]) }}" method = "POST">
                                                            @csrf
                                                            
                                                            <button type = "submit" class = "text-danger delete" title="delete">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                        
                                                        
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </table>
                                    @else
                                        No Contacts
                                    @endif
                                </small>
                            </h4>

                            <div class="full-width text-right">
                                <a href="#add-card-contact" class="waves-effect waves-teal btn-custom teal-text" style="text-transform: initial;"><i class="fa fa-plus"></i> Add Contact</a>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    

                    <div class="custom-card">
                        <div class="card-inner">

                            <h3 class="blue-text">People with my card ({{ number_format($approved_requests_count) }})</h3>

                            @if(count($approved_requests))
                                @foreach($approved_requests as $card_request)
                                    <div class="custom-card-grey mb-5 tiny">
                                        <div class="card-inner">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <a href="{{ route('user.other-profile.view', ['username' => $card_request->sender->username ]) }}">
                                                        <img src="{{ profile_thumb($card_request->sender-> thumbnail) }}" alt="{{ $card_request->sender->name }}" class="responsive-img circle mt-5">    
                                                    </a>
                                                    
                                                </div>

                                                <div class="col-xs-8">
                                                    <a href="{{ route('user.other-profile.view', ['username' => $card_request->sender->username ]) }}" class="blue-text">{{ characters($card_request->sender->name,12) }}</a> 
                                                    
                                                    {{-- @if($card_request->sender->position)
                                                        <br><small>{{ $card_request->sender->position }} &nbsp;</small>
                                                    @endif --}}
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                @if($approved_requests_count > 10)
                                    <p class = "text-center">
                                        <a href="{{ route('user.people-with-my-card') }}" class="btn orange mt-10">See all</a>
                                    </p>
                                @endif

                            @else
                                <p>No one has your card</p>
                            @endif
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

    </section>

    @include('pages.user.modals.edit-card')
    @include('pages.user.modals.add-card-contact')

@endsection