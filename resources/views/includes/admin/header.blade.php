<!DOCTYPE html>
<!--
   This is a starter template page. Use this page to start your new project from
   scratch. This page gets rid of all links and provides the needed markup only.
   -->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ my_asset('ico/favicon.png') }}">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ my_asset('css/admin/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ my_asset('css/admin//bootstrap-extension.css') }}" rel="stylesheet">
    <!-- This is Sidebar menu CSS -->
    <link href="{{ my_asset('css/admin/sidebar-nav.min.css') }}" rel="stylesheet">
    <!-- This is a Animation CSS -->
    <link href="{{ my_asset('css/admin/animate.css') }}" rel="stylesheet">
    <!-- This is a Custom CSS -->
    <link href="{{ my_asset('css/admin/style.min.css') }}" rel="stylesheet">
    <link href="{{ my_asset('css/admin/morris.css') }}" rel="stylesheet">
                              
    <!-- color CSS you can use different color css from css/colors folder -->
    <!-- We have chosen the skin-gray-dark (gray-dark.css) for this starter
         page. However, you can choose any other skin from folder css / colors .
         -->
    <link href="{{ my_asset('css/admin/colors/megna.css') }}" id="theme" rel="stylesheet">

    <link href="{{ my_asset('css/user/custom.css') }}" id="theme" rel="stylesheet">

    <script src="{{ my_asset('js/jquery-2.1.3.min.js') }}"></script>
    <script src="{{ my_asset('js/admin/raphael.min.js') }}"></script>
    <script src="{{ my_asset('js/admin/morris.min.js') }}"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>

<body class="fix-sidebar">
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>

    <div id="wrapper">
        @include('includes.admin.top-nav')
        
        @include('includes.admin.left-sidebar')
        

        <!-- Page Content -->
        <div id="page-wrapper">


            <div class="container-fluid">
                <div class="row bg-title">
                    <!-- .page title -->
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">@yield('title')
                            
                        </h4> 
                    </div>

                    <div class="row col-lg-9 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title full-width">
                            @if(isset($nav) && $nav == 'view-user')
                            <span class="">
                                @if($user->closed)
                                    <span class="label label-table label-danger">CLOSED</span>
                                @elseif($user->suspended)
                                    <span class="label label-table label-waring">SUSPENDED</span>
                                @else
                                    <span class="label label-table label-success">ACTIVE</span>
                                @endif
                            </span>

                            
                                @if(!$me)
                                    <span>
                                        @if($user->closed)
                                            <form action="{{ route('admin.user.reopen', ['username' => $user->username]) }}" method = "POST" class="form-inline pull-right">
                                                @csrf

                                                <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-undo"></i> RESTORE USER</button>
                                            </form>

                                        @else
                                            <a href="" data-toggle="modal" data-target="#close-account-modal" class="btn btn-sm btn-danger pull-right"><i class="fa fa-times"></i> CLOSE ACCOUNT</a> 

                                            @include('pages.admin.modals.close-account')
                                        @endif
                                    
                                    </span>
                                    &nbsp; 
                                    <span class="">
                                        @if($user->suspended)
                                            <form action="{{ route('admin.user.activate', ['username' => $user->username]) }}" method = "POST" class="form-inline pull-right mr-10">
                                                @csrf

                                                <button type="submit" class="btn btn-sm btn-info">ACTIVATE USER</button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.user.suspend', ['username' => $user->username]) }}" method = "POST"  class="form-inline pull-right mr-10">
                                                @csrf

                                                <button type="submit" class="btn btn-sm btn-danger">SUSPEND USER</button>
                                            </form>
                                        @endif
                                    </span>
                                @endif
                            @endif


                            @if(isset($nav) && $nav == 'view-event')
                            <span class="">
                                {!! $event->closed ? '<span class="label label-danger">CLOSED</span>' : '<span class="label label-success">OPEN</span>' !!}
                            </span>
                              
                                @if(!$event->closed)
                                    <form action="{{ route('admin.event.close', ['slug' => $event->slug]) }}" method = "POST" class="form-inline pull-right">
                                        @csrf

                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> CLOSE EVENT</button>
                                    </form>
                                @endif
                                
                            @endif

                        </h4>
                        
                    </div>
                    <!-- /.page title -->
                </div>
                <!-- .row -->
                

                
