@foreach($products as $product)
    <x-forms::table.row :model="$product" :no-checkbox="! empty($no_checkbox)">

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

        <x-forms::table.cell name="address" />

        <x-forms::table.cell name="slug" />

        <x-forms::table.cell name="description" multiline />

        <x-forms::table.cell name="price" />

        <x-forms::table.cell name="stock" />

        <x-forms::table.cell name="on_sale" />

        <x-forms::table.cell name="features" />

        <x-forms::table.cell name="published_at" />

        <x-forms::table.cell name="expire_at" />

        <x-forms::table.cell name="released_on" />

        <x-forms::table.cell name="sale_time" />

        <x-forms::table.cell name="status" />

        <x-forms::table.cell name="category" />

        <x-forms::table.cell name="manufactured_year" />

    </x-forms::table.row>
@endforeach
