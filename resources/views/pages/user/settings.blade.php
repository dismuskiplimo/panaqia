@extends('layouts.user')

@section('title', 'Settings')
@section('content')
    
    

    <section class="py-50">

        <div class="container">
            <div class="custom-card">
                <div class="card-inner">
                    <div class="row">
                        <div class="col-sm-3">
                            <ul class="nav nav-pills nav-stacked" role="tablist">
                                <li role="presentation" class="nav-tab active">
                                    <a href="#account" aria-controls="account info" role="tab" data-toggle="tab" class="blue-text white-focus"><i class="fa fa-user"></i> Acount</a>
                                </li>
                                
                                <li role="presentation" class="nav-tab">
                                    <a href="#password" aria-controls="change password" role="tab" data-toggle="tab" class="blue-text white-focus"><i class="fa fa-key"></i> Password</a>
                                </li>

                                <li role="presentation" class="nav-tab">
                                    <a href="#close-account" aria-controls="close account" role="tab" data-toggle="tab" class="blue-text white-focus"><i class="fa fa-times"></i> Close Account</a>
                                </li>
                               
                            </ul> 
                        </div>

                        <div class="col-sm-9">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="account">
                                    <h3>ACCOUNT</h3>

                                    <form action="{{ route('account.update') }}" method = "POST">
                                        @csrf

                                        <div class="input-field">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" value = "{{ Auth::user()->name }}" id="name" class="form-control">
                                        </div>

                                        <div class="input-field">
                                            <label for="username">Username</label>
                                            <input type="text" name="username" value = "{{ Auth::user()->username }}" id="username" class="form-control">
                                        </div>

                                        <div class="input-field">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" value = "{{ Auth::user()->email }}" id="email" class="form-control">
                                        </div>


                                        <div class="input-field">
                                            <p>Country</p>

                                            <select name="country_code" id="country_code" required="">
                                                <option value=""> --select counrty--</option>

                                                @foreach($countries as $country)
                                                    <option value="{{ $country->code }}"{{ Auth::user()->country_code == $country->code ? ' selected' : '' }}>{{ $country->name }}</option>
                                                @endforeach


                                            </select>
                                            
                                        </div>

                                        <div class="form-group ">
                                            <button type="submit" class="btn btn-info">Update</button>

                                            
                                        </div>


                                    </form>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="password">
                                    <h3>CHANGE PASSWORD</h3>

                                    <form action="{{ route('password.change') }}" method = "POST">
                                        @csrf

                                        <div class="input-field">
                                            <label for="old-password">Old Password</label>
                                            <input type="password" name = "old_password" id = "old-password" class="form-control" required="">
                                        </div>

                                        <div class="input-field">
                                            <label for="new-password">New Password</label>
                                            <input type="password" name = "new_password" id = "new-password" class="form-control" required="">
                                        </div>

                                        <div class="input-field">
                                            <label for="new-password-confirmation">Repeat New Password</label>
                                            <input type="password" name = "new_password_confirmation" id = "new-password-confirmation" class="form-control" required="">
                                        </div>

                                        <div class="form-group">
                                            <button type = "submit" class="btn btn-info"><i class="fa fa-key"></i> Change Password</button>
                                        </div>
                                    </form>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="close-account">
                                    <h3>CLOSE ACCOUNT</h3>

                                    <form action="{{ route('user.close-account') }}" method = "POST" class="close-account-form">
                                        @csrf

                                        <div class="input-field">
                                            <label for="closed-reason">Reason for Closing Account</label>
                                            <textarea name = "reason" id = "closed-reason" class="materialize-textarea"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <button type = "submit" class="btn red close-account-button"><i class="fa fa-times"></i> Close Account</button>
                                        </div>
                                    </form>
                                </div>
                                
                            </div>

                            
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>

@endsection