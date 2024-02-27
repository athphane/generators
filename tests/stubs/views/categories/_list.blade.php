@foreach($categories as $category)
    <x-forms::table.row
        model="category"
        :model-id="$category->id"
        :no-checkbox="! empty($no_checkbox)"
    >

        <x-forms::table.cell :label="{{ __('Name') }}">
            {!! $category->admin_link !!}
            <div class="table-actions actions">
                <a class="actions__item"><span>{{ __('ID: :id', ['id' => $category->id]) }}</span></a>

                @can('view', $category)
                    <a class="actions__item zmdi zmdi-eye" href="{{ route('admin.categories.show', $category) }}" title="View">
                        <span>{{ __('View') }}</span>
                    </a>
                @endcan

                @can('update', $category)
                    <a class="actions__item zmdi zmdi-edit" href="{{ route('admin.categories.edit', $category) }}" title="Edit">
                        <span>{{ __('Edit') }}</span>
                    </a>
                @endcan

                @can('delete', $category)
                    <a class="actions__item delete-link zmdi zmdi-delete" href="#" data-request-url="{{ route('admin.categories.destroy', $category) }}"
                       data-redirect-url="{{ Request::fullUrl() }}" title="Delete">
                        <span>{{ __('Delete') }}</span>
                    </a>
                @endcan
            </div>
        </x-forms::table.cell>

        <x-forms::table.cell name="slug" :label="__('Slug')" />

    </x-forms::table.row>
@endforeach
