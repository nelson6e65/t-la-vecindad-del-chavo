@extends('errors::illustrated-layout')

@section('code', '405')
@section('title', __('Method Not Allowed'))

@section('image')
    <div style="background-image: url({{ asset('/svg/404.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', __('Sorry, the page you are looking for could not be displayed.'))
