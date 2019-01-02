<!--header start-->
        <header id="header" class="tt-nav nav-border-bottom">

            <div class="header-sticky light-header">

                <div class="container">

                    <div class="search-wrapper">
                        <div class="search-trigger pull-right">
                            <div class='search-btn'></div>
                            <i class="material-icons">&#xE8B6;</i>
                        </div>

                        <!-- Modal Search Form -->
                        <i class="search-close material-icons">&#xE5CD;</i>
                        <div class="search-form-wrapper">
                            <form action="{{ route('event.search') }}" class="white-form" method = "GET">
                                
                                <div class="input-field">
                                    <input type="text" name="search" id="search">
                                    <label for="search" name = "event" class="">Search Event</label>
                                </div>
                                <button class="btn pink search-button waves-effect waves-light" type="submit"><i class="material-icons">&#xE8B6;</i></button>
                                
                            </form>
                        </div>
                    </div><!-- /.search-wrapper -->

                    <div id="matrox-menu" class="menuzord">

                        <!--logo start-->
                        <a href="{{ route('home') }}" class="logo-brand">
                            <img class="retina" src="{{ my_asset('img/blue-logo.png') }}" alt="{{ config('app.name') }} Logo" title="Home" />

                            
                        </a>
                        <!--logo end-->

                            @if(!Auth::check())
                                 


                                 <ul class="menuzord-menu pull-right">
                                    <li{!! $nav == 'user.events' ? ' class="active"' : '' !!}>
                                        <a href="{{ route('event.search') }}">Events Album</a>
                                    </li>

                                    

                                    <li{!! $nav == "login" ? ' class="active"' : '' !!}><a href="{{ route('login') }}">Login</a></li>

                                    <li{!! $nav == "register" ? ' class="active"' : '' !!}><a href="{{ route('register') }}">Signup</a></li>
                                </ul>
                            @else
                                @if(Auth::user()->is_user())
                                    <ul class="menuzord-menu">
                                        
                                        

                                        <li{!! $nav == 'events' ? ' class="active"' : '' !!}>
                                            <a href="{{ route('event.search') }}">Events Album</a>
                                        </li>

                                        <li class=""><a href="{{ route('user.event.add') }}">Create Event</a></li>

                                        <li{!! $nav == 'user.profile' ? ' class="active"' : '' !!}><a href="{{ route('user.profile') }}">My Profile</a></li>

                                        

                                        <li{!! $nav == 'user.card' ? ' class="active"' : '' !!}><a href="{{ route('user.card') }}">My Card</a></li>

                                        <li{!! $nav == 'user.my-cards' ? ' class="active"' : '' !!}><a href="{{ route('user.my-cards') }}">Cards Album</a></li>
                                    </ul>
                                
                                    
                                    <ul class="menuzord-menu pull-right">
                                       <li>
                                            <a href="{{ route('user.notifications.get') }}" title="Notifications">
                                                
                                                <span class="fa fa-globe medium" style = "font-size:1.6em; margin-top:5px">
                                                    <?php   
                                                        $initial_notifications = Auth::user()->notifications()->where('read', 0)->orderBy('created_at', 'DESC')->get();
                                                    ?>
                                                    <span class="nav-count" id="notification-count">{{ count($initial_notifications) ? number_format(count($initial_notifications)) : '' }}</span>    
                                                </span>

                                                
                                                
                                            </a>
                                            
                                            
                                        </li>

                                        <li{!! $nav == 'user.messages' ? ' class="active"' : '' !!}>
                                            <a href="{{ route('user.messages') }}" title="Messages">
                                                <span class="fa fa-envelope medium" style = "font-size:1.6em; margin-top:5px">
                                                    <?php
                                                        $message_count = Auth::user()->message_notifications()->where('read', 0)->orderBy('created_at', 'DESC')->get();
                                                    ?>
                                                    <span class="nav-count" id = "message-count">{{ count($message_count) ? number_format(count($message_count)) : '' }}</span>
                                                </span>
                                            </a>
                                        </li>

                                       <li>
                                            <a href="javascript:void(0)">
                                                <img src="{{ profile_thumb(Auth::user()->thumbnail) }}" alt="{{ Auth::user()->name }}" class="img-circle size-40">
                                                

                                                {{ names(Auth::user()->name)[0] }}</a>
                                            
                                            <ul class="dropdown">
                                                <li{!! $nav == 'user.my-events' ? ' class="active"' : '' !!}>
                                                    <a href="{{ route('user.my-events') }}">My Events</a>
                                                </li>

                                                <li{!! $nav == 'user.booked-events' ? ' class="active"' : '' !!}>
                                                    <a href="{{ route('user.booked-events') }}">Booked Events</a>
                                                </li>

                                                <li{!! $nav == 'user.event-requests' ? ' class="active"' : '' !!}>
                                                    <a href="{{ route('user.event-requests') }}">Event Requests</a>
                                                </li>

                                                <li{!! $nav == 'user.transactions' ? ' class="active"' : '' !!}>
                                                    <a href="{{ route('user.transactions') }}">Transactions</a>
                                                </li>

                                                <li><a href="{{ route('user.settings') }}">Settings</a></li>
                                                <li>
                                                    <a id = "logout-button" href="#">Log Out</a>
                                                    <form action="{{ route('logout') }}" id = "logout-form" method = "POST" class="inline">
                                                        {{ csrf_field() }}
                                                    </form>

                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                @elseif(Auth::user()->is_manager())

                                @elseif(Auth::user()->is_admin())
                                    <ul class="menuzord-menu pull-right">
                                        <li{!! $nav == 'events' ? ' class="active"' : '' !!}>
                                            <a href="{{ route('event.search') }}">Events Album</a>
                                        </li>
                                        
                                        <li>
                                            <a href="javascript:void(0)">{{ strtoupper(names(Auth::user()->name)[0]) }}</a>
                                            
                                            <ul class="dropdown">
                                                

                                                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                                <li>
                                                    <a id = "logout-button" href="#">Log Out</a>
                                                    <form action="{{ route('logout') }}" id = "logout-form" method = "POST" class="inline">
                                                        {{ csrf_field() }}
                                                    </form>

                                                </li>
                                            </ul>
                                        </li>

                                    </ul>
                                @endif
                            @endif
                       
                    </div>
                </div>
            </div>
        </header>
        <!--header end-->