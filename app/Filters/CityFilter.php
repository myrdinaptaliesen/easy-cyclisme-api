<?php

namespace App\Filters;

class CityFilter
{
    public function filter($builder, $value)
    {
        return $builder->where('city_competition', $value);
    }
}