<x-forms::infolist :model="$product">
    <x-forms::text-entry name="name" inline />

    <x-forms::text-entry name="address" inline />

    <x-forms::text-entry name="slug" inline />

    <x-forms::text-entry name="description" multiline inline />

    <x-forms::text-entry name="price" inline />

    <x-forms::text-entry name="stock" inline />

    <x-forms::boolean-entry name="on_sale" inline />

    <x-forms::text-entry name="features" inline />

    <x-forms::text-entry name="published_at" inline />

    <x-forms::text-entry name="expire_at" inline />

    <x-forms::text-entry name="released_on" inline />

    <x-forms::text-entry name="sale_time" inline />

    <x-forms::text-entry name="status" inline />

    <x-forms::text-entry name="category" inline />

    <x-forms::text-entry name="manufactured_year" inline />
</x-forms::infolist>
