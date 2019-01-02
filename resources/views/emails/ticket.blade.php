@extends('layouts.email')

@section('title', $title)

@section('content')
	<p>Thank you for booking {{ $event->name }}. Attached is your ticket for the event</p>
	<br>

	<p>Note: This is a generated mail. Do not reply.</p>
	<p>Regards, <br> {{ config('app.name') }}</p>
@endsection