@extends('errors::illustrated-layout')

@section('title', __('Not Found'))
@section('code', '404')
@section('image')
    <img alt="Page not found" class="h-48 lg:h-auto" src="{{ asset('assets/images/404-error-page-not-found-with-people-connecting-a-plug-animate.svg') }}">
@endsection
@section('message')
    <div class="intro-x text-xl lg:text-3xl font-medium mt-5">Oops. Tidak dapat terhubung ke halaman.</div>
    <div class="intro-x text-lg mt-3">Anda mungkin salah memasukan alamat atau halaman telah di pindah.</div>
    <a href="{{ url('/') }}" class="intro-x btn py-3 px-4 text-white border-white dark:border-darkmode-400 dark:text-slate-200 mt-10">Kembali ke Home</a>
@endsection

@section('script')
    <script type='text/javascript'>document.addEventListener('DOMContentLoaded', function () {window.setTimeout(document.querySelector('svg').classList.add('animated'),1000);})</script>
@endsection
