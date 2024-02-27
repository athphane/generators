@foreach($products as $product)
    <x-forms::table.row
        model="product"
        :model-id="$product->id"
        :no-checkbox="! empty($no_checkbox)"
    >

        <x-forms::table.cell :label="{{ __('Name') }}">
            {!! $product->admin_link !!}
            <div class="table-actions actions">
                <a class="actions__item"><span>{{ __('ID: :id', ['id' => $product->id]) }}</span></a>

                @if($product->trashed())
                    @can('forceDelete', $product)
                        <a class="actions__item delete-link zmdi zmdi-delete" href="#" data-request-url="{{ route('admin.products.force-delete', $product) }}"
                           data-redirect-url="{{ Request::fullUrl() }}" title="Delete Permanently">
                            <span>{{ __('Delete Permanently') }}</span>
                        </a>
                    @endcan

                    @can('restore', $product)
                        <a class="actions__item restore-link zmdi zmdi-time-restore-setting" href="#" data-post-url="{{ route('admin.products.restore', $product) }}"
                           data-redirect-url="{{ Request::fullUrl() }}" title="Restore">
                            <span>{{ __('Restore') }}</span>
                        </a>
                    @endcan
                @else
                    @can('view', $product)
                        <a class="actions__item zmdi zmdi-eye" href="{{ route('admin.products.show', $product) }}" title="View">
                            <span>{{ __('View') }}</span>
                        </a>
                    @endcan

                    @can('update', $product)
                        <a class="actions__item zmdi zmdi-edit" href="{{ route('admin.products.edit', $product) }}" title="Edit">
                            <span>{{ __('Edit') }}</span>
                        </a>
                    @endcan

                    @can('delete', $product)
                        <a class="actions__item delete-link zmdi zmdi-delete" href="#" data-request-url="{{ route('admin.products.destroy', $product) }}"
                           data-redirect-url="{{ Request::fullUrl() }}" title="Delete">
                            <span>{{ __('Delete') }}</span>
                        </a>
                    @endcan
                @endif
            </div>
        </x-forms::table.cell>

        <x-forms::table.cell name="address" :label="__('Address')" />

        <x-forms::table.cell name="slug" :label="__('Slug')" />

        <x-forms::table.cell name="description" :label="__('Description')" multiline />

        <x-forms::table.cell name="price" :label="__('Price')" />

        <x-forms::table.cell name="stock" :label="__('Stock')" />

        <x-forms::table.cell name="on_sale" :label="__('On Sale')" />

        <x-forms::table.cell name="features" :label="__('Features')" />

        <x-forms::table.cell name="published_at" :label="__('Published At')" />

        <x-forms::table.cell name="expire_at" :label="__('Expire At')" />

        <x-forms::table.cell name="released_on" :label="__('Released On')" />

        <x-forms::table.cell name="sale_time" :label="__('Sale Time')" />

        <x-forms::table.cell name="status" :label="__('Status')" />

        <x-forms::table.cell name="category" :label="__('Category')" />

        <x-forms::table.cell name="manufactured_year" :label="__('Manufactured Year')" />

    </x-forms::table.row>
@endforeach
