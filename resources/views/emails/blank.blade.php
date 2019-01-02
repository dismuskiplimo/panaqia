@extends('layouts.email')

@section('title', $title)

@section('content')
	<p>{{ $reason }}</p>
	<br>

	<p>Regards, <br> {{ config('app.name') }} Team</p>
@endsection