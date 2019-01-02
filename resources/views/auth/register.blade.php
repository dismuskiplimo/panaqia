<?php $nav = "register"; ?>

@extends('layouts.user')

@section('content')


@section('title', 'Register')
@section('content')

    <section class="py-50">
        <div class="container">
            <div class="row">
                
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="custom-card">
                        <div class="card-inner">
                          <h3 class="text-center">Signup, its FREE</h3>
                          

                          <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="input-field">
                                <label for="name" class="">{{ __('Name') }}*</label>
                 
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                                
                            </div>

                            <div class="input-field">
                                <label for="email" class="">{{ __('E-Mail Address') }}*</label>

                               
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                
                            </div>

                            <div class="input-field">
                                <label for="username" class="">{{ __('Username (min:6 characters)') }}*</label>

                               
                                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required>

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback text-danger">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                                
                            </div>


                            <div class="input-field">
                                <p class="text-muted">Country*</p>

                               {{--  <span class="flag-icon flag-icon-ke"></span> --}}

                                <select name="country_code" id="country_code" class="{{ $errors->has('country_code') ? ' is-invalid' : '' }}" required />
                                    <option value="">Select Country....</option>
                                    
                                    @foreach(App\Country::orderBy('name', 'ASC')->get() as $country)
                                        <option value="{{ $country->code }}">
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @if ($errors->has('country_id'))
                                    <span class="invalid-feedback text-danger">
                                        <strong>{{ $errors->first('country_id') }}</strong>
                                    </span>
                                @endif
                                
                            </div>

                            <div class="input-field">
                                <label for="password" class="">{{ __('Password') }}*</label>

                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                
                            </div>

                            <div class="input-field">
                                <label for="password-confirm" class="">{{ __('Confirm Password') }}*</label>

                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                               
                            </div>

                            <div class="form-group mt-20">
                                <p>By clicking the sign up button, you are agreeable to our <a href="{{ route('terms') }}" class="blue-text"`>Terms and Conditions</a></p>
                                
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Sign Up') }}


                                </button>

                                <span class = "pull-right mt-10">Already have an account? <a href="{{ route('login') }}" class="blue-text">Log in here</a></span>
                                
                            </div>
                        </form>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
