@extends('errors::illustrated-layout')

@section('title', __('Forbidden'))
@section('code', '403')
@section('image')
    <img alt="403-error" class="h-48 lg:h-auto" src="{{ asset('assets/images/403-error-illustration.svg') }}">
@endsection
@section('message')
    <div class="intro-x text-xl lg:text-3xl font-medium mt-5">Oops. Anda tidak memiliki akses.</div>
    <div class="intro-x text-lg mt-3">Anda tidak memiliki peran untuk mengakses halaman ini.</div>
    <a href="{{ url('/') }}" class="intro-x btn py-3 px-4 text-white border-white dark:border-darkmode-400 dark:text-slate-200 mt-10">Kembali ke Home</a>
@endsection
