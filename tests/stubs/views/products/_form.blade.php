<x-forms::card>
    <x-forms::text name="name" :label="__('Name')" required inline />

    <x-forms::text name="address" :label="__('Address')" required inline />

    <x-forms::text name="slug" :label="__('Slug')" required inline />

    <x-forms::textarea name="description" :label="__('Description')" inline />

    <x-forms::number name="price" :label="__('Price')" min="0" max="999999999999" step="0.01" required inline />

    <x-forms::number name="stock" :label="__('Stock')" min="0" max="4294967295" step="1" required inline />


    on_sale
    features
    published_at
    expire_at
    released_on
    sale_time
    status
    category_id
    manufactured_year

    <x-forms::button-group inline>
        <x-forms::submit color="success" class="btn--icon-text btn--raised">
            <i class="zmdi zmdi-check"></i> {{ __('Save') }}
        </x-forms::submit>

        <x-forms::link-button color="light" class="btn--icon-text" :url="route('admin.products.index')">
            <i class="zmdi zmdi-close-circle"></i> {{ __('Cancel') }}
        </x-forms::link-button>
    </x-forms::button-group>
</x-forms::card>

@include('admin.components.floating-submit')
