<?php

namespace App\Filters;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class CompetitionFilter extends AbstractFilter
{
    protected $filters = [
        'city_competition' => CityFilter::class
    ];
}