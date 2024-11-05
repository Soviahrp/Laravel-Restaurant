<?php

namespace App\Http\Services;

use App\Models\Category;
use Dotenv\Parser\Value;

class CategoryService
{
    public function select($column = null, $Value = null)
    {
        if ($column) {
            return Category::where($column, $Value)
            ->select('id', 'uuid', 'title', 'slug')->firstOrFail();
        }

        return Category::latest()->get(['id', 'uuid', 'title', 'slug']);
    }
}
