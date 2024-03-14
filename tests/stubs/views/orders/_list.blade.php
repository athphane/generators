@foreach($orders as $order)
    <x-forms::table.row :model="$order" :no-checkbox="! empty($no_checkbox)">

        <x-forms::table.cell :label="__('Order No')">
            {!! $order->admin_link !!}
            <div class="table-actions actions">
                <a class="actions__item"><span>{{ __('ID: :id', ['id' => $order->id]) }}</span></a>

                @can('view', $order)
                    <a class="actions__item zmdi zmdi-eye" href="{{ route('admin.orders.show', $order) }}" title="View">
                        <span>{{ __('View') }}</span>
                    </a>
                @endcan

                @can('update', $order)
                    <a class="actions__item zmdi zmdi-edit" href="{{ route('admin.orders.edit', $order) }}" title="Edit">
                        <span>{{ __('Edit') }}</span>
                    </a>
                @endcan

                @can('delete', $order)
                    <a class="actions__item delete-link zmdi zmdi-delete" href="#" data-request-url="{{ route('admin.orders.destroy', $order) }}"
                       data-redirect-url="{{ Request::fullUrl() }}" title="Delete">
                        <span>{{ __('Delete') }}</span>
                    </a>
                @endcan
            </div>
        </x-forms::table.cell>

        <x-forms::table.cell name="category" />

        <x-forms::table.cell name="productSlug" />

        <x-forms::table.cell name="status" />

    </x-forms::table.row>
@endforeach
