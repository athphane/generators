<x-forms::card>
    <x-forms::text name="name" :label="__('Name')" maxlength="255" required inline />

    <x-forms::text name="address" :label="__('Address')" maxlength="255" required inline />

    <x-forms::text name="slug" :label="__('Slug')" maxlength="255" required inline />

    <x-forms::textarea name="description" :label="__('Description')" inline />

    <x-forms::number name="price" :label="__('Price')" min="0" max="999999999999" step="0.01" required inline />

    <x-forms::number name="stock" :label="__('Stock')" min="0" max="4294967295" step="1" required inline />

    <x-forms::checkbox name="on_sale" :label="__('On Sale')" value="1" inline />

    <x-forms::select name="features[]" :label="__('Features')" :options="['apple', 'orange']" multiple required inline />

    <x-forms::datetime name="published_at" :label="__('Published At')" required inline />

    <x-forms::datetime name="expire_at" :label="__('Expire At')" required inline />

    <x-forms::date name="released_on" :label="__('Released On')" required inline />

    <x-forms::time name="sale_time" :label="__('Sale Time')" required inline />

    <x-forms::select name="status" :label="__('Status')" :options="['draft', 'published']" required inline />

    <x-forms::select name="category" :label="__('Category')" :options="\App\Models\Category::query()" inline />

    <x-forms::number name="manufactured_year" :label="__('Manufactured Year')" min="1900" max="2100" step="1" required inline />

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
