<x-forms::infolist :model="$product">
    <x-forms::text-entry name="name" :label="__('Name')" inline />

    <x-forms::text-entry name="address" :label="__('Address')" inline />

    <x-forms::text-entry name="slug" :label="__('Slug')" inline />

    <x-forms::text-entry name="description" :label="__('Description')" multiline inline />

    <x-forms::text-entry name="price" :label="__('Price')" inline />

    <x-forms::text-entry name="stock" :label="__('Stock')" inline />

    <x-forms::boolean-entry name="on_sale" :label="__('On Sale')" inline />

    <x-forms::text-entry name="features" :label="__('Features')" inline />

    <x-forms::text-entry name="published_at" :label="__('Published At')" inline />

    <x-forms::text-entry name="expire_at" :label="__('Expire At')" inline />

    <x-forms::text-entry name="released_on" :label="__('Released On')" inline />

    <x-forms::text-entry name="sale_time" :label="__('Sale Time')" inline />

    <x-forms::text-entry name="status" :label="__('Status')" inline />

    <x-forms::text-entry name="category" :label="__('Category')" inline />

    <x-forms::text-entry name="manufactured_year" :label="__('Manufactured Year')" inline />
</x-forms::infolist>
