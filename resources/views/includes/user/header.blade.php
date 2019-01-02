<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{ config('app.name') }} is an event management platform where members can share contacts and communicate">
        <meta name="keywords" content="communication, event management, card sharing">
        <meta name="author" content="https://technopro-solutions.co.ke">

        

        <title>@yield('title') | {{ config('app.name') }}</title>

        <!--  favicon -->
        <link rel="shortcut icon" href="{{ my_asset('img/ico/favicon.png') }}">
        <!--  apple-touch-icon -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ my_asset('img/ico/apple-touch-icon-144-precomposed.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ my_asset('img/ico/apple-touch-icon-114-precomposed.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ my_asset('img/ico/apple-touch-icon-72-precomposed.png') }}">
        <link rel="apple-touch-icon-precomposed" href="{{ my_asset('img/ico/apple-touch-icon-57-precomposed.png') }}">


        
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,500,700,900' rel='stylesheet' type='text/css'>
        <!-- FontAwesome CSS -->
        <link href="{{ my_asset('css/user/font-awesome.min.css') }}" rel="stylesheet">
        <!-- Material Icons CSS -->
        <link href="{{ my_asset('css/user/material-icons.css') }}" rel="stylesheet">

        <!-- owl.carousel -->
        <link href="{{ my_asset('css/user/owl.carousel.css') }}" rel="stylesheet">
        <link href="{{ my_asset('css/user/owl.theme.default.min.css') }}" rel="stylesheet">
        <!-- flexslider -->
        <link href="{{ my_asset('css/user/flexslider.css') }}" rel="stylesheet">
        <!-- materialize -->
        <link href="{{ my_asset('css/user/materialize.min.css') }}" rel="stylesheet">
        <!-- Bootstrap -->
        <link href="{{ my_asset('css/user/bootstrap.min.css') }}" rel="stylesheet">
        <!-- shortcodes -->
        <link href="{{ my_asset('css/user/shortcodes/shortcodes.css') }}" rel="stylesheet">
        
        <link href="{{ my_asset('css/user/remodal.css') }}" rel="stylesheet">

        <link href="{{ my_asset('css/user/remodal-default-theme.css') }}" rel="stylesheet">
        
        <link href="{{ my_asset('css/user/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">

        <link href="{{ my_asset('css/user/image-reader.css') }}" rel="stylesheet">
        <!-- Style CSS -->
        <link href="{{ my_asset('css/user/style.css') }}" rel="stylesheet">
        
        <link href="{{ my_asset('css/user/snackbar.min.css') }}" rel="stylesheet">

        <link href="{{ my_asset('css/user/material.css') }}" rel="stylesheet">
        
        <link href="{{ my_asset('css/user/flag-icon.min.css') }}" rel="stylesheet">
        
        <link href="{{ my_asset('css/user/custom.css') }}" rel="stylesheet">

        <!-- jQuery -->
        <script src="{{ my_asset('js/jquery-2.1.3.min.js') }}"></script>
        <script src="{{ my_asset('js/user/snackbar.min.js') }}"></script>


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body id="top" class="has-header-search">