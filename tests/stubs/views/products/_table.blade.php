<x-forms::table
    model="products"
    :no-bulk="! empty($no_bulk)"
    :no-checkbox="! empty($no_checkbox)"
    :no-pagination="! empty($no_pagination)"
>

    @if(empty($no_bulk))
    <x-slot:bulk-form :action="route('admin.products.bulk')">
        @include('admin.products._bulk')
    </x-slot:bulk-form>
    @endif

    <x-slot:headers>
        <x-forms::table.heading :label="__('Name')" sortable="name" />
        <x-forms::table.heading :label="__('Address')" sortable="address" />
        <x-forms::table.heading :label="__('Slug')" sortable="slug" />
        <x-forms::table.heading :label="__('Description')" />
        <x-forms::table.heading :label="__('Price')" sortable="price" />
        <x-forms::table.heading :label="__('Stock')" sortable="stock" />
        <x-forms::table.heading :label="__('On Sale')" />
        <x-forms::table.heading :label="__('Features')" />
        <x-forms::table.heading :label="__('Published At')" sortable="published_at" />
        <x-forms::table.heading :label="__('Expire At')" sortable="expire_at" />
        <x-forms::table.heading :label="__('Released On')" sortable="released_on" />
        <x-forms::table.heading :label="__('Sale Time')" sortable="sale_time" />
        <x-forms::table.heading :label="__('Status')" />
        <x-forms::table.heading :label="__('Category')" />
        <x-forms::table.heading :label="__('Manufactured Year')" sortable="manufactured_year" />
    </x-slot:headers>

    <x-slot:rows>
        @if($products->isEmpty())
            <x-forms::table.empty-row columns="15" :no-checkbox="! empty($no_checkbox)">
                {{ __('No matching products found.') }}
            </x-forms::table.empty-row>
        @else
            @include('admin.products._list')
        @endif
    </x-slot:rows>

    @if(empty($no_pagination))
    <x-slot:pagination>
        {{ $products->links('forms::material-admin-26.pagination') }}
    </x-slot:pagination>
    @endif

</x-forms::table>
