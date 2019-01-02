<?php
    $nav = 'password.reset';
    $title = 'Password Reset';
?>

@extends('layouts.user')

@section('title', $title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 py-100">
            
                <h4>{{ __('Reset Password') }}</h4>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.request') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="input-field">
                            <label for="email">{{ __('E-Mail Address') }}</label>
    
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email or old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                           
                        </div>

                        <div class="input-field">
                            <label for="password">{{ __('Password') }}</label>
    
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                            
                        </div>

                        <div class="input-field">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                           
                                <input id="password-confirm" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group">
                            
                            <button type="submit" class="btn btn-primary">
                                {{ __('Reset Password') }}
                            </button>
                            
                        </div>
                    </form>
                
            </div>
        </div>
    </div>
</div>
@endsection
