<?php

namespace App\Filters;

class DateCompetitionFilter
{
    public function filter($builder, $value)
    {
        return $builder->where('date_competition', $value);
    }
}