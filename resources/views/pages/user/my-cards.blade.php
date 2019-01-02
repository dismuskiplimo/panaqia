@extends('layouts.user')

@section('title', $title)
@section('content')


    <section class="py-50">

        <div class="container">

            <div class="row">
                
                <div class="col-xs-12">
                    @if($approved_requests_count)

                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <h3>MY CARDS ({{ number_format(count($approved_requests)) }})</h3>
                                <hr class="mb-20">
                            </div>

                            @foreach($approved_requests as $card_request)
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-image">
                                            <a href="{{ route('user.other-profile.view', ['username' => $card_request->user->username ]) }}">
                                                @if($card_request->card->background)
                                                    <img src="{{ image($card_request->card->background) }}" alt="">
                                                @else
                                                    <img src="{{ my_asset('img/300x200.png') }}" alt="">
                                                @endif    
                                            </a>
                                            
                                            
                                            <span class="card-thumb size-100 mt-20">
                                                 <a href="{{ route('user.other-profile.view', ['username' => $card_request->user->username ]) }}">
                                                    @if($card_request->card->thumbnail)
                                                        <img src="{{ image($card_request->card->thumbnail) }}" class = "circle-img responsive-img dark-drop-shadow" alt="">
                                                    @else
                                                        <img src="{{ my_asset('img/default-user.png') }}" alt="logo" class="img-responsive">
                                                    @endif
                                                </a>      
                                            </span>

                                            <span class="card-title">{{ $card_request->user->name }}</span>


                                       </div>

                                        <div class="card-content match-height">
                                            {{-- <h4>{{ $card_request->card->company ? : 'Company' }}  <br>
                                                <small>{{ $card_request->card->position? : 'Position' }}</small>
                                                
                                            </h4>
                                            

                                            <h4>About <br>
                                                <small>
                                                    {{ $card_request->card->description ? : 'No data' }}
                                                </small>
                                            </h4> --}}

                                            <h4> 
                                                <?php 
                                                    $card_contacts = $card_request->user->contacts()->where('section', 'CARD')->orderBy('created_at', 'desc')->get();
                                                ?>
                                                <small>
                                                    @if(count($card_contacts))
                                                        <br>
                                                        <table class = "table table-sm table-condensed">
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
                                                                               
                                                                                {{ characters($contact->contact, 25) }}
                                                                            </a>
                                                                            
                                                                        @elseif($contact->type == 'ADDRESS')
                                                                            {{ $contact->contact }} 
                                                                        @elseif($contact->type == 'FACEBOOK')
                                                                            <a href="{{ $contact->contact }}" target="_blank" style="text-transform:lowercase; color: #2196F3;">
                                                                                {{ characters($contact->contact,25) }}
                                                                            </a>
                                                                            
                                                                        @elseif($contact->type == 'TWITTER')
                                                                            <a href="{{ $contact->contact }}" target="_blank" style="text-transform:lowercase; color: #2196F3;">
                                                                                {{ characters($contact->contact,25) }}
                                                                            </a>
                                                                            
                                                                        @elseif($contact->type == 'LINKEDIN')
                                                                            <a href="{{ $contact->contact }}" target="_blank" style="text-transform:lowercase; color: #2196F3;">
                                                                                {{ characters($contact->contact, 25) }}
                                                                            </a>
                                                                            
                                                                        @endif
                                                                        
                                                                    </td>
                                                                    
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    @else
                                                        No Contacts
                                                    @endif
                                                </small>
                                            </h4>
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            @endforeach
 
                        </div>
                    @else
                        <h2 class = "text-center intro-title py-50">NO CARDS</h2>
                    @endif
                </div>
            </div>

        </div>

    </section>

@endsection