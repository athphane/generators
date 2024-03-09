<?php
/**
 * Categories Export
 */

namespace App\Exports;

use App\Models\Category;

class CategoriesExport extends ModelExport
{
    /**
     * @var string
     */
    protected $model_class = Category::class;
}
