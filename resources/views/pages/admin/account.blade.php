@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-6 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats"> <i class="ti-money bg-megna"></i>
                    <div class="bodystate">
                        <h4>{{ $options->currency }} {{ number_format($options->account_balance_mpesa,2) }}</h4> 
                        <span class="text-muted">Total Collected (MPESA)</span> </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats"> <i class="ti-money bg-megna"></i>
                    <div class="bodystate">
                        <h4>{{ $options->currency }} {{ number_format($options->profit_mpesa,2) }}</h4> 
                        <span class="text-muted">Total Commission (MPESA)</span> </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats"> <i class="ti-money bg-megna"></i>
                    <div class="bodystate">
                        <h4>{{ $options->currency }} {{ number_format($options->to_be_payed_out_mpesa,2) }}</h4> 
                        <span class="text-muted">Total To be Payed Out (MPESA)</span> </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats"> <i class="ti-money bg-megna"></i>
                    <div class="bodystate">
                        <h4>{{ $options->paypal_currency }} {{ number_format($options->account_balance_paypal,2) }}</h4> 
                        <span class="text-muted">Total Collected (Paypal)</span> </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats"> <i class="ti-money bg-megna"></i>
                    <div class="bodystate">
                        <h4>{{ $options->paypal_currency }} {{ number_format($options->profit_paypal,2) }}</h4> 
                        <span class="text-muted">Total Commission (Paypal)</span> </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats"> <i class="ti-money bg-megna"></i>
                    <div class="bodystate">
                        <h4>{{ $options->paypal_currency }} {{ number_format($options->to_be_payed_out_paypal,2) }}</h4> 
                        <span class="text-muted">Total To be Payed Out (Paypal)</span> </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="white-box">
                <div class="r-icon-stats"> <i class="ti-money bg-megna"></i>
                    <div class="bodystate">
                        <h4>{{ number_format($options->event_commission,2) }} %</h4> 
                        <span class="text-muted">Commission</span> </div>
                </div>
            </div>
        </div>
	</div>
@endsection