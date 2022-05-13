<?php

namespace App\Filters;

class DisciplineFilter
{
    public function filter($builder, $value)
    {
        return $builder->where('discipline_id', $value);
    }
}