<?php

namespace App\Http\Controllers\Api;

use Javaabu\QueryBuilder\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class CategoriesController extends ApiController
{
    /**
     * Get the base query
     *
     * @return Builder
     */
    protected function getBaseQuery(): Builder
    {
        return Category::query();
    }

    /**
     * Get the allowed fields
     *
     * @return array
     */
    protected function getAllowedFields(): array
    {
        return array_diff(\Schema::getColumnListing('categories'), (new Category)->getHidden());
    }

    /**
     * Get the allowed includes
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
        ];
    }

    /**
     * Get the allowed appends
     *
     * @return array
     */
    protected function getAllowedAppends(): array
    {
        return [
        ];
    }

    /**
     * Get the allowed sorts
     *
     * @return array
     */
    protected function getAllowedSorts(): array
    {
        return [
            'id',
            'created_at',
            'updated_at',
            'name',
            'slug',
        ];
    }

    /**
     * Get the default sort
     *
     * @return string
     */
    protected function getDefaultSort(): string
    {
        return 'created_at';
    }

    /**
     * Get the allowed filters
     *
     * @return array
     */
    protected function getAllowedFilters(): array
    {
        return [
            'id',
            'name',
            'slug',
            AllowedFilter::scope('search'),
        ];
    }
}
