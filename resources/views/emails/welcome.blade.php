@extends('layouts.email')

@section('title', $title)

@section('content')
	<p>Thank you for registering at {{ config('app.name') }}.</p>
	<br>

	<p>Note: This is a generated mail. Do not reply.</p>

	<p>Regards, <br> {{ config('app.name') }}</p>
@endsection