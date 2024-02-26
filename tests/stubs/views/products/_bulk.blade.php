@php
    $actions = [];

    if (auth()->user()->can('delete_products')) {
        $actions['delete'] = __('Delete');
    }
@endphp

<x-forms::bulk-actions :actions="$actions" model="products" />
