@extends('admin.products.products')

@section('page-title', __('Edit Product'))

@section('content')
    <x-forms::form method="PATCH" :model="$product" :action="route('admin.products.update', $product)">
    @include('admin.products._form')
    </x-forms::form>
@endsection
