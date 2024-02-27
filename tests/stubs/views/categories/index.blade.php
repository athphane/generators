@extends('admin.categories.categories')

@section('page-subheading')
    <small>{{ $title }}</small>
@endsection

@section('content')
    @if($categories->isNotEmpty() || App\Models\Category::exists())
        <x-forms::card>
            <x-forms::form
                :action="route('admin.categories.index')"
                :model="request()->query()"
                id="filter"
                method="GET"
            >
                @include('admin.categories._filter')
            </x-forms::form>

            @include('admin.categories._table')
        </x-forms::card>
    @else
        <x-forms::no-items
            icon="zmdi zmdi-folder"
            :create-action="route('admin.categories.create')"
            :model_type="__('categories')"
            :model="App\Models\Category::class"
        />
    @endif
@endsection
