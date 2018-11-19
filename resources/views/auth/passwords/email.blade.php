@extends('auth.master')

@section('page-title', 'Reset your password')

@section('content')
@include('auth.passwords.email-ajax')
@endsection
