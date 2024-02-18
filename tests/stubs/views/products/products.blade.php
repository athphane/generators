@extends('layouts.admin')

@section('title', 'Products')
@section('page-title', __('Products'))

@section('top-search')
    @include('admin.partials.search-model', [
        'search_route' => 'admin.products.index',
        'search_placeholder' => __('Search for products...'),
    ])
@endsection

@section('model-actions')
    @include('admin.products._actions')
@endsection
