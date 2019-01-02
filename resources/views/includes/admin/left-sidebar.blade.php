<!-- Left navbar-header -->
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                <!-- input-group -->
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search..."> 
                    
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
                    </span> 
                </div>
                <!-- /input-group -->
            </li>
            
            <li class="user-pro">
                <a href="" class="waves-effect">
                    <img src="{{ profile_thumb(Auth::user()->thumbnail) }}" alt="user-img" class="img-circle"> 
                    <span class="hide-menu">{{ Auth::user()->name }}
                        <span class="fa arrow"></span>
                    </span>
                </a>

                <ul class="nav nav-second-level">

                    <li>
                        <a href="{{ route('admin.account.settings') }}">
                            <i class="ti-settings"></i> Account Setting
                        </a>
                    </li>

                    <li>
                        <a href="#"  id = "logout-button">
                            <i class="fa fa-power-off"></i> Logout

                            <form action="{{ route('logout') }}" id = "logout-form" method = "POST" class="inline">
                                {{ csrf_field() }}
                            </form>
                        </a>
                    </li>
                </ul>
            </li>
            
            <li class="nav-small-cap m-t-10">-- Main Menu</li>

            <li>
                <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                    <i class="ti-dashboard fa-fw"></i> 
                    <span class="hide-menu">Dashboard</span>
                </a> 
            </li>

            <li>
                <a href="{{ route('admin.account') }}" class="waves-effect">
                    <i class="ti-money fa-fw"></i> 
                    <span class="hide-menu">Account</span>
                </a> 
            </li>
            

            <li>
                <a href="{{ route('admin.transactions') }}" class="waves-effect">
                    <i class="ti-split-h fa-fw"></i> 
                    <span class="hide-menu">Transactions</span>
                </a> 
            </li>

            <li> 
                <a href="#" class="waves-effect">
                    <i class="ti-microphone fa-fw"></i> 
                    <span class="hide-menu">Events
                        <span class="fa arrow"></span>
                    </span>
                </a>

                <ul class="nav nav-second-level">
                    <?php
                        $all_events_count = \App\Event::count() ? : '';
                        $active_events_count = \App\Event::where('start_date', '>=', defaultDate($options->today))->where('closed', 0)->count() ? : '';
                        $past_events_count = \App\Event::where('start_date', '<', defaultDate($options->today))->count() ? : '';
                        $featured_events_count = \App\Event::where('start_date', '>=', defaultDate($options->today))->where('featured', 1)->count() ? : '';
                        $cancelled_events_count = \App\Event::where('cancelled', 1)->count() ? : '';
                        $closed_events_count = \App\Event::where('closed', 1)->count() ? : '';
                    ?>

                    <li>
                        <a href="{{ route('admin.events') }}">All Events
                            <span class="label label-rouded label-purple pull-right">{{ $all_events_count }}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.events.active') }}">Active Events
                            <span class="label label-rouded label-purple pull-right">{{ $active_events_count }}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.events.featured') }}">Featured Events
                            <span class="label label-rouded label-purple pull-right">{{ $featured_events_count }}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.events.closed') }}">Closed Events
                            <span class="label label-rouded label-purple pull-right">{{ $closed_events_count }}</span>
                        </a>
                    </li>                    

                    <li>
                        <a href="{{ route('admin.events.past') }}">Past Events
                            <span class="label label-rouded label-purple pull-right">{{ $past_events_count }}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.events.cancelled') }}">Cancelled Events
                            <span class="label label-rouded label-purple pull-right">{{ $cancelled_events_count }}</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li> 
                <a href="#" class="waves-effect">
                    <i class="ti-user fa-fw"></i> 
                    <span class="hide-menu">Users
                        <span class="fa arrow"></span>
                    </span>
                </a>
                
                <ul class="nav nav-second-level">
                    <?php
                        $active_users = \App\User::where('usertype', 'USER')->where('is_admin', 0)->where('suspended', 0)->count() ? : '';
                        $suspended_users = \App\User::where('usertype', 'USER')->where('is_admin', 0)->where('suspended', 1)->count() ? : '';

                        $adm = \App\User::where('usertype', 'ADMIN')->where('is_admin', 1)->count() ? : '';
                    ?>

                    <li> 
                        <a href="{{ route('admin.users.active') }}">Active Users 
                            <span class="label label-rouded label-purple pull-right">{{ $active_users }}</span>
                        </a> 
                    </li>

                    <li> 
                        <a href="{{ route('admin.users.suspended') }}">Suspended Users 
                            <span class="label label-rouded label-purple pull-right">{{ $suspended_users }}</span>
                        </a> 

                    </li>

                    <li> 
                        <a href="{{ route('admin.admins') }}">Admins 
                            <span class="label label-rouded label-purple pull-right">{{ $adm }}</span>
                        </a>
                    </li>
                    
                </ul>
            </li>

            <li>
                <a href="{{ route('admin.site-settings') }}" class="waves-effect">
                    <i class="ti-settings fa-fw"></i> 
                    <span class="hide-menu">Site Settings</span>
                </a> 
            </li>
        </ul>
    </div>
</div>
<!-- Left navbar-header end -->