@extends('layouts.user')

@section('title', $title)
@section('content')
    
    <section class="py-50">

        <div class="container">
            <div class="row">
                <div class="col-xs-8 col-xs-offset-2">
                    <h3 class="text-center">SELECT PAYMENT METHOD</h3> <br>

                    <form action="" method = "GET">
                        

                        <div class="custom-card">
                            <div class="card-inner">
                                <div class="row">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <table class="full-width">
                                            <tr>
                                                <td>
                                                    <label for="mpesa">
                                                        <img src="{{ my_asset('img/payments/mpesa.png') }}" alt="MPESA" class = "size-100">
                                                    </label>
                                                </td>
                                                <td>
                                                    <p style="margin:auto auto">
                                                        <input type="radio" name="payment_method" class="with-gap" id="mpesa" value = "mpesa" />
                                                        <label for="mpesa">MPESA</label>
                                                    </p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <label for="credit-card">
                                                        <img src="{{ my_asset('img/payments/stripe.png') }}" alt="MPESA" class = "size-100">
                                                    </label>
                                                </td>

                                                <td>
                                                    <p style="margin:auto auto">
                                                        <input type="radio" name="payment_method" class="with-gap" id="credit-card" value = "cc" checked="" />
                                                        <label for="credit-card">Credit Card</label>
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>        
                                    </div>
                                </div>
                                

                               
                            </div>
                        </div>

                        <div class="text-center mt-10">
                            <button type="submit" class="btn waves-effect waves-light green center">PROCEED</button>    
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>

    </section>

@endsection