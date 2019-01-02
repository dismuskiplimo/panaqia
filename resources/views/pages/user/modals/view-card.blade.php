<div class="remodal" data-remodal-id="view-card" role="dialog" aria-labelledby="Edit Event" aria-describedby="modal1Desc">
    
      <div class = "text-left">
        
        
        
            <div class="card">
                <div class="card-image">
                    <a href="{{ route('user.other-profile.view', ['username' => $user->username ]) }}">
                        @if($user->card->background)
                            <img src="{{ image($user->card->background) }}" alt="">
                        @else
                            <img src="{{ my_asset('img/300x200.png') }}" alt="">
                        @endif    
                    </a>
                    
                    
                    <span class="card-thumb size-200 pt-20">
                         <a href="{{ route('user.other-profile.view', ['username' => $user->username ]) }}">
                            @if($user->card->thumbnail)
                                <img src="{{ image($user->card->thumbnail) }}" class = "circle-img responsive-img dark-drop-shadow" alt="">
                            @else
                                <img src="{{ my_asset('img/default-user.png') }}" alt="logo" class="img-responsive">
                            @endif
                        </a>      
                    </span>

                    <span class="card-title">{{ $user->name }}</span>


               </div>

                <div class="card-content match-height">
                    {{-- <h4>{{ $user->card->company ? : 'Company' }}  <br>
                        <small>{{ $user->card->position? : 'Position' }}</small>
                        
                    </h4>
                    

                    <h4>About <br>
                        <small>
                            {{ $user->card->description ? : 'No details' }}
                        </small>
                    </h4> --}}

                    <h4>
                        <?php 
                            $card_contacts = $user->contacts()->where('section', 'CARD')->orderBy('created_at', 'desc')->get();
                        ?>
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
        
       
        
        <br>
        
        <button data-remodal-action="cancel" class="btn red right">CLOSE</button>
      </div>
      
</div>