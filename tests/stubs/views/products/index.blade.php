@extends('admin.products.products')

@section('page-title')
    {{ if_route('admin.products.trash') ? __('Deleted Products') : __('Products') }}
@endsection

@section('page-subheading')
    <small>{{ $title }}</small>
@endsection

@section('content')
    @if($products->isNotEmpty() || App\Models\Product::exists())
        <div class="card">
            <x-forms::form
                :action="route(if_route('admin.products.trash') ? 'admin.products.trash' : 'admin.products.index')"
                :model="request()->query()"
                id="filter"
                method="GET"
            >
                @include('admin.products._filter')
            </x-forms::form>

            @include('admin.products._table', [
                'no_bulk' => $trashed,
                'no_checkbox' => $trashed,
            ])
        </div>
    @else
        <x-forms::no-items
            icon="zmdi zmdi-shopping-cart"
            :create-action="route('admin.products.create')"
            :model_type="__('products')"
            :model="App\Models\Product::class"
        />
    @endif
@endsection
