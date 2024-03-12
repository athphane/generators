<x-forms::filter>
    <div class="row">
        <div class="col-md-3">
            <x-forms::text name="search" :label="__('Search')" :placeholder="__('Search..')" :show-errors="false" :inline="false" />
        </div>
        <div class="col-md-3">
            <x-forms::select2
                name="date_field"
                :label="__('Date to Filter')"
                :options="\App\Models\Product::getDateFieldsList()"
                allow-clear
                :show-errors="false"
            />
        </div>
        <div class="col-md-3">
            <x-forms::datetime name="date_from" :show-errors="false" />
        </div>
        <div class="col-md-3">
            <x-forms::datetime name="date_to" :show-errors="false" />
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <x-forms::per-page />
        </div>
        <div class="col-md-3">
            <x-forms::filter-submit :cancel-url="if_route('admin.products.trash') ? route('admin.products.trash') : route('admin.products.index')" export />
        </div>
    </div>
</x-forms::filter>
