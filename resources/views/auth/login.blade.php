<?php $nav = 'login'; ?>
@extends('layouts.user')

@section('title', 'Login')
@section('content')

    <section class="py-50">

        <div class="container">
            <div class="row">
                
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="custom-card">
                        <div class="card-inner">
                            <h3 class="text-center">Login</h3>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="input-field">
                                    <label for="email" class="">{{ __('E-Mail Address') }}</label>

                                   
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    
                                </div>

                                <div class="input-field">
                                    <label for="password" class="">{{ __('Password') }}</label>

                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    
                                </div>

                                <div class="input-field">
                    
                                             <input type="checkbox" name="remember" id = "remember-me" {{ old('remember') ? 'checked' : '' }}> 
                                             <label for = "remember-me">{{ __('Remember Me') }}</label>
                                       
                                   
                                </div>

                                <div class="form-group mt-20 row">
                                    
                                    
                                    <div class="col-sm-3">
                                        <div class="">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                        
                                    </div>

                                    <div class="col-sm-9 text-right">
                                       <p class = "text-right"><a href="{{ route('password.request') }}" class="blue-text">
                                                {{ __('Forgot Your Password?') }}
                                            </a></p>
                                            
                                        
                                        <p class="text-right">Don't have an account? <a href="{{ route('register') }}" class="blue-text">Sign Up here</a> </p>
                                        
                                    </div>

                                    
                                        
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

    </section>

@endsection
 