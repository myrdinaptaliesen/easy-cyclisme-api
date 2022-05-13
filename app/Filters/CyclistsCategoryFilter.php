<?php

namespace App\Filters;

class CyclistsCategoryFilter
{
    public function filter($builder, $value)
    {
        return $builder->where('cyclists_category_id', $value);
    }
}