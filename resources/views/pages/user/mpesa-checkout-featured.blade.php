@extends('layouts.user')

@section('title', $title)
@section('content')
    
    

    <section class="py-50">

        <div class="container">
            <div class="row">
                
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="custom-card">
                        <div class="card-inner">
                            <h3 class="text-center"><strong>{{ strtoupper($title) }}</strong> <br><br> PAYMENT FOR FEATURING THE EVENT <br>  <strong>{{ strtoupper($event->name) }}</strong></h3>

                            <hr><br>

                            <ol>
                                <li>Please enter your phone number below in the format <strong>2547xxxxxxxx</strong> e.g <strong>254720543564</strong>.</li>
                                <li>Click on Submit.</li>
                                <li>A dialog will appear on your phone requesting you to enter your <strong>MPESA PIN</strong></li>
                                <li>Enter your <strong>MPESA PIN</strong> and press <strong>Ok</strong></li>
                                <li><strong>{{ $options->currency }} {{ number_format($event->featured_amount, 2) }}</strong> Will be deducted automatically.</li>

                                <p><strong>NB.</strong> If no Popup menu appears on your phone, your MPESA menu may be out of date. Please dial <strong>*234*1*6#</strong> to update your MPESA menu</p>
                            </ol>

                            <form action="{{ route('user.mpesa.request', ['id' => $event->id, 'type' => 'feature']) }}" method="POST">
                                @csrf
                                <div class="input-field">
                                    <label for="">Phone number (2547XXXXXXXX)</label>
                                    <input type="number" name="phone" class="form-control" required="" value="{{ old('phone') }}" id="phone">
                                </div>
                                
                                <button class="btn waves-effect waves-light">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection