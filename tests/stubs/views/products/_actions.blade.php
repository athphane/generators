<div class="actions">
    @if(isset($product))
        @can('delete', $product)
        <a class="actions__item delete-link zmdi zmdi-delete" href="#"
            data-request-url="{{ route('admin.products.destroy', $product) }}"
            data-redirect-url="{{ route('admin.products.index') }}" title="Delete">
            <span>{{ __('Delete') }}</span>
        </a>
        @endcan

        @can('viewLogs', $product)
        <a class="actions__item zmdi zmdi-assignment" href="{{ $product->log_url }}" target="_blank" title="View Logs">
            <span>{{ __('View Logs') }}</span>
        </a>
        @endcan

        @can('update', $product)
            <a class="actions__item zmdi zmdi-edit" href="{{ route('admin.products.edit', $product) }}" title="Edit">
                <span>{{ __('Edit') }}</span>
            </a>
        @endcan

        @can('view', $product)
            <a class="actions__item zmdi zmdi-eye" href="{{ route('admin.products.show', $product) }}" title="View">
                <span>{{ __('View') }}</span>
            </a>
        @endcan
    @endif

    @can('create', App\Models\Product::class)
    <a class="actions__item zmdi zmdi-plus" href="{{ route('admin.products.create') }}" title="Add New">
        <span>{{ __('Add New') }}</span>
    </a>
    @endcan

    @can('trash', App\Models\Product::class)
    <a class="{{ App\Models\Product::onlyTrashed()->exists() ? 'indicating' : '' }} actions__item zmdi zmdi-time-restore-setting"
        href="{{ route('admin.products.trash') }}" title="Trash">
        <span>{{ __('Trash') }}</span>
    </a>
    @endcan

    @can('viewAny', App\Models\Product::class)
    <a class="actions__item zmdi zmdi-view-list-alt" href="{{ route('admin.products.index') }}" title="List All">
        <span>{{ __('View All') }}</span>
    </a>
    @endcan
</div>
