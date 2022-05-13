<?php

namespace App\Filters;

use App\Filters\AbstractFilter;
use App\Filters\DisciplineFilter;
use App\Filters\DateCompetitionFilter;
use App\Filters\CyclistsCategoryFilter;
use Illuminate\Database\Eloquent\Builder;

class CompetitionFilter extends AbstractFilter
{
    protected $filters = [
        'discipline_id' => DisciplineFilter::class,
        'cyclists_category_id' => CyclistsCategoryFilter::class,
        'date_competition' => DateCompetitionFilter::class,
    ];
}