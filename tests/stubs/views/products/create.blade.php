@extends('admin.products.products')

@section('page-title', __('New Product'))

@section('content')
    <x-forms::form :action="route('admin.products.store')">
    @include('admin.products._form')
    </x-forms::form>
@endsection
