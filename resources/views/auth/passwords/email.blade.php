<?php
    $nav = 'password.reset';
    $title = 'Password Reset';
?>

@extends('layouts.user')

@section('title', $title)

@section('content')
<div class="container">
    <div class="row py-100">
        <div class="col-md-6 col-md-offset-3">
            
                <h4>{{ __('Reset Password') }}</h4>

                
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="input-field">
                        <label for="email">{{ __('E-Mail Address') }}</label>

                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                        
                    </div>

                    <div class="input-field">
                        
                        <button type="submit" class="btn btn-primary">
                            {{ __('Send Password Reset Link') }}
                        </button>
                        
                    </div>
                </form>
                
            
        </div>
    </div>
</div>
@endsection
