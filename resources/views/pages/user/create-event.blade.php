@extends('layouts.user')

@section('title', $title)
@section('content')

    <section class="py-50">

        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    
                </div>
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="custom-card">
                        <div class="card-inner">
                            <h3 class="text-center text-bold">CREATE EVENT</h3>
                            <hr><br>
                            <form action="{{ route('user.event.add') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h3 class="mb-20">Event Details</h3>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-12">
                                        <p>Banner</p>
                                        <div class="drop">
                                            <div class="uploader">
                                                <label class="drop-label grey-text">Drag and drop image here</label>
                                                <input type="file" class="image-upload drop-photo" id="photo" name="banner" accept="image/*">
                                            </div>
                                            <div id="image-preview"></div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-field">
                                            <label for="name">Event Name</label>
                                            <input type="text" name="name" id="name" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-field">
                                            
                                            <label for="start_date">Start Date</label>
                                            <input type="text" name="start_date" id="start_date" class="start-date" required="">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="input-field">
                                            <label for="end_date">End Date</label>
                                            <input type="text" name="end_date" id="end_date" class="end-date" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-field">
                                            <label for="start_time">Start Time</label>
                                            <input type="text" name="start_time" id="start_time" class="start-time" required="">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="input-field">
                                            <label for="end_time">End Time</label>
                                            <input type="text" name="end_time" id="end_time" class="end-time" required="">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <input class="with-gap" type="checkbox" name = "include_weekends" id="include-1" checked="" />
                                        <label for="include-1">Include Weekends</label>
                                    </div>
                                </div>

                                <div class="input-field">
                                    
                                    <p>Timezone</p>
                                   

                                    <select name="timezone_id" id="timezone_id" class="{{ $errors->has('timezone_id') ? ' is-invalid' : '' }}" required />
                                        <option value="">Select Timezone....</option>
                                        
                                        @foreach($timezones as $timezone)
                                            <option value="{{ $timezone->id }}"{{ $timezone->zone == 'Africa/Nairobi' ? ' selected' : '' }}>
                                                {{ $timezone->zone }}
                                            </option>
                                        @endforeach
                                    </select>
             
                                </div>

                                <div class="input-field">
                                    
                                    <p>Event Category</p>
                                   

                                    <select name="event_category_id" id="event_category_id" class="{{ $errors->has('event_category_id') ? ' is-invalid' : '' }}" required />
                                        <option value="">Select Category....</option>
                                        
                                        @foreach($event_categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
             
                                </div>


                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-field">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" rows = "6" class="materialize-textarea" required=""></textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-field">
                                            <label for="venue">Venue</label>
                                            <input type="text" name="venue" id="venue" required="">
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="input-field">
                                            <label for="map">Map (Paste google maps embed code here) - Optional</label>
                                            <textarea name="map" id="map" rows = "6" class="materialize-textarea"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <h3 class="my-20">Attendance fee ({{ $options->currency }})</h3>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="input-field">
                                            <label for="speaker-price">Speaker</label>
                                            <input type="number" name="speaker_price" value="0" id="speaker-price" min="0">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="input-field">
                                            <label for="delegate-price">Delegate</label>
                                            <input type="number" name="delegate_price" value="0" id="delegate-price" min="0">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="input-field">
                                            <label for="exhibitor-price">Exhibitor</label>
                                            <input type="number" name="exhibitor_price" value="0" id="exhibitor-price" min="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <h3 class="my-20">Restrictions</h3>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">      
                                        <input class="with-gap" name="restriction" type="radio" id="no-restriction" value = "0" checked />
                                        <label for="no-restriction">No Restriction</label>        
                                    </div>

                                    <div class="col-sm-6">
                                        <input class="with-gap" name="restriction" type="radio" id="restriction" value = "1" />
                                        <label for="restriction">Invite Only</label>    
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-12">
                                        <h3 class="my-20">Payments</h3>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">      
                                        <input class="with-gap" name="payment_method" type="radio" id="payment_method-1" value = "COMMISSION" checked />
                                        <label for="payment_method-1">Commission on ticket sales</label>        
                                    </div>

                                    <div class="col-sm-4">
                                        <input class="with-gap" name="payment_method" type="radio" id="payment_method-2" value = "PROMOTION" />
                                        <label for="payment_method-2">Event Promotion Fees</label>    
                                    </div>

                                    <div class="col-sm-4">
                                        <input class="with-gap" name="payment_method" type="radio" id="payment_method-3" value = "FREE" />
                                        <label for="payment_method-3">Free listing</label>    
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <h3 class="my-20">Services</h3>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">      
                                        <input class="with-gap" type="checkbox" name = "collect_revenue" id="service-1" />
                                        <label for="service-1">Revenue Collection</label>     
                                    </div>

                                    <div class="col-sm-4">
                                        <input class="with-gap" type="checkbox" name = "promote_event" id="service-2" />
                                        <label for="service-2">Event Promotion</label>    
                                    </div>

                                    <div class="col-sm-4">
                                        <input class="with-gap" type="checkbox" name = "manage_attendees" id="service-3" />
                                        <label for="service-3">Attendee Management</label>    
                                    </div>
                                </div>

                                <hr class="py-20">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type = "submit" class="btn waves-effect waves-light">
                                            <i class="fa fa-plus"></i> Publish Event
                                        </button>
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