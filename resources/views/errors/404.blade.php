<?php $nav = '404'; ?>

@extends('layouts.user')

@section('title', '404 Not Found')
@section('content')

    <section class="error-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <i class="fa fa-dropbox"></i>
                </div>
                
                <div class="col-sm-7">
                    <div class="error-info">
                        <h1 class="mb-30">404</h1>
                        <span class="error-sub">OOPS! PAGE NOT FOUND</span>

                        <p>Sorry, but we can’t seem to find the page you are looking for.</p>
                        <a class="btn btn-lg waves-effect waves-light" href="{{ route('home') }}">Take Me Home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection