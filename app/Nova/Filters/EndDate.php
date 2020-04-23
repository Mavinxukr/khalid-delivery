<?php

namespace App\Nova\Filters;

use App\Helpers\TransactionHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Nova\Filters\DateFilter;

class EndDate extends DateFilter
{
    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        TransactionHelper::getTransactions();
        return $query->where('transaction_datetime','<=', Carbon::parse($value)->addDay());
    }
}
