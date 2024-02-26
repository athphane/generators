<div class="actions">
    @if(isset($category))
        @can('delete', $category)
        <a class="actions__item delete-link zmdi zmdi-delete" href="#"
            data-request-url="{{ route('admin.categories.destroy', $category) }}"
            data-redirect-url="{{ route('admin.categories.index') }}" title="Delete">
            <span>{{ __('Delete') }}</span>
        </a>
        @endcan

        @can('viewLogs', $category)
        <a class="actions__item zmdi zmdi-assignment" href="{{ $category->log_url }}" target="_blank" title="View Logs">
            <span>{{ __('View Logs') }}</span>
        </a>
        @endcan

        @can('update', $category)
            <a class="actions__item zmdi zmdi-edit" href="{{ route('admin.categories.edit', $category) }}" title="Edit">
                <span>{{ __('Edit') }}</span>
            </a>
        @endcan

        @can('view', $category)
            <a class="actions__item zmdi zmdi-eye" href="{{ route('admin.categories.show', $category) }}" title="View">
                <span>{{ __('View') }}</span>
            </a>
        @endcan
    @endif

    @can('create', App\Models\Category::class)
    <a class="actions__item zmdi zmdi-plus" href="{{ route('admin.categories.create') }}" title="Add New">
        <span>{{ __('Add New') }}</span>
    </a>
    @endcan

    @can('viewAny', App\Models\Category::class)
    <a class="actions__item zmdi zmdi-view-list-alt" href="{{ route('admin.categories.index') }}" title="List All">
        <span>{{ __('View All') }}</span>
    </a>
    @endcan
</div>
