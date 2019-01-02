@extends('layouts.user')

@section('title', $title)
@section('content')
    

    <section class="py-50">

        <div class="container">
            <div class="row">
                <div class="col-sm-4">

                    <div class="custom-card mb-10">
                        <div class="card-inner">
                            @if(count($conversations))
                                <div class=" chats-wrapper">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h3>Conversations ({{ number_format(count($conversations)) }})</h3>

                                            <form action="{{ route('user.messages') }}" method="GET">
                                                <div class="input-field">
                                                    <label for="search-field">Search</label>
                                                    <input type="text" name = "search" id = "search-field" required="">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    
                                    @foreach($conversations as $con)
                                        <?php 
                                            if($con->from_id == $user->id){
                                                $other = $con->to;

                                                if(!$other){
                                                    continue;
                                                }
                                            }else{
                                                $other = $con->from;

                                                if(!$other){
                                                    continue;
                                                }
                                            }
                                        ?>
                                        
                                        <a href="{{ route('user.message.new', ['recepient' => $other->username]) }}">
                                            <div class="row mb-10 blue-hover py-5{{ $recepient->id == $other->id ? ' active' : '' }}">
                                                <div class="col-xs-3">
                                                    <img src="{{ profile_thumb($other->thumbnail) }}" alt="{{ $other->name }}" class="responsive-img p-5 circle">
                                                </div>

                                                <div class="col-xs-9">
                                                    <small>
                                                        <strong>{{ $other->name }}</strong> <br>
                                                        <span>{{ $con->updated_at->diffForHumans() }}</span>
                                                    </small>
                                                </div>

                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @else

                                <p class="text-center pt-10">No Conversations yet</p>

                            @endif


                        </div>
                    </div>
                    
                </div>

                <div class="col-sm-8">
                    <div class="custom-card">
                        <div class="card-inner">
                                <div class="row">
                                    <div class="col-xs-12">
                                
                                        
                                            <div class="conversation-header full-width">
                                                <div class="row">
                                                    <div class="col-xs-2 text-center">
                                                        <a href="{{ route('user.other-profile.view', ['username' => $recepient->username]) }}">
                                                            <img src="{{ profile_thumb($recepient->thumbnail) }}" alt="{{ $recepient->name }}" class="size-50 mtn-10 circle" title="View Profile">
                                                        </a>
                                                        
                                                    </div>

                                                    <div class="col-xs-10">
                                                        <a href="{{ route('user.other-profile.view', ['username' => $recepient->username]) }}">{{ $recepient->name }}</a>
                                                        
                                                        <div class="mtn-10">
                                                            @if($recepient->last_seen)
                                                                <small>{{ $recepient->last_seen->diffForHumans() }}</small>
                                                            @endif
                                                                <small>&nbsp;</small>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="mini-messages-wrapper">
                                                <div class="messages">
                                                    <div class="py-10">

                                                            @if(count($conversation->messages))
                                                                @foreach($conversation->messages()->orderBy('created_at', 'asc')->get() as $message)
                                                                    <small>
                                                                        <span class="row message">
                                                                            @if($message->from_id == $user->id)
                                                                                <div class="speech right">
                                                                                    <div class="text-left">
                                                                                        {{ $message->message }} <br>    
                                                                                    </div>
                                                                                    
                                                                                    <small>{{ $message->created_at->diffForHumans() }}</small>
                                                                                </div> 
                                                                            @else
                                                                                <div class="speech left">
                                                                                    <div>
                                                                                        {{ $message->message }} <br>   
                                                                                    </div>

                                                                                     
                                                                                    <small>{{ $message->created_at->diffForHumans() }}</small>
                                                                                </div>

                                                                            @endif    
                                                                        </span>
                                                                        
                                                                    </small>
                                                                @endforeach
                                                            @else
                                                               
                                                                    <small>
                                                                        <span class="row message first"><span>
                                                                            <div class="centered">
                                                                                <h4>Send your first message to <strong>{{ $recepient->name }} </strong></h4>
                                                                            </div>
                                                                        </span>
                                                                    </small>
                                                                        
                                                                
                                                            @endif
                                                        
                                                            
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            

                                            <div class="conversation-footer full-width">
                                                <form action="{{ route('user.message.new', ['recepient' => $recepient->username]) }}" method="POST" id = "compose-form">
                                                    @csrf
                                                        
                                                        
                                                            <div class="col-xs-11">
                                                                <div class="input-field mt-0">
                                                                   
                                                                    <textarea name="message" id="message-content" rows="1" class="materialize-textarea tiny" required="required" placeholder="message"></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-xs-1">
                                                                 <span class="conversation-button">
                                                                    <button type = "submit" class="btn-floating btn-large waves-effect waves-light blue">
                                                                        <i class="material-icons">send</i>
                                                                    </button>
                                                                 </span>
                                                                
                                                                 
                                                            </div>    
                                                                      
                                                    
                                                </form>
                                            </div>
                                        </div>
                                    </div>            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    @if($nav == 'user.message')
        <input type="hidden" id = "conversation-route" value = "{{ route('user.message.new', ['recepient' => $recepient->username]) }}">
        <script src = "{{ my_asset('js/user/conversation.js') }}"></script>
    @endif

@endsection