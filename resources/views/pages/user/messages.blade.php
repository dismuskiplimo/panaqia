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
                                <div class="chats-wrapper">
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
                                    
                                    
                                    @foreach($conversations as $conversation)
                                        <?php 
                                            if($conversation->from_id == $user->id){
                                                $other = $conversation->to;

                                                if(!$other){
                                                    continue;
                                                }
                                            }else{
                                                $other = $conversation->from;

                                                if(!$other){
                                                    continue;
                                                }
                                            }
                                        ?>
                                        
                                        <a href="{{ route('user.message.new', ['recepient' => $other->username]) }}">
                                            <div class="row mb-10 blue-hover py-5">
                                                <div class="col-xs-3">
                                                    <img src="{{ profile_thumb($other->thumbnail) }}" alt="{{ $other->name }}" class="responsive-img p-5 circle">
                                                </div>

                                                <div class="col-xs-9">
                                                    <small>
                                                        <strong>{{ $other->name }}</strong> <br>
                                                        <span>{{ $conversation->updated_at->diffForHumans() }}</span>
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
                            <div class="messages-wrapper pointer">
                                <div class="messages centered">
                                    <h4>Please select a conversation to view</h4>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    @if($nav == 'user.messages')
        <input type="hidden" id = "conversations-route" value = "{{ route('user.messages') }}">
        <script src = "{{ my_asset('js/user/conversations.js') }}"></script>
    @endif

@endsection