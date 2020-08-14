<?php

namespace App\Nova\Filters;

use App\Models\Brands\Brand;
use App\Models\Provider\Provider;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class Company extends BooleanFilter
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
        $providers = array_filter($value);
        foreach ($providers as $key => $value){
            if($value){
                $arr[]=Provider::where('name', $key)->first()->id;
            }
        }

        if(count($providers) > 0){
            return $query->whereIn('provider_id', $arr)
                ->where('status', 'done')
                ->get();
        }
        return $query;
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        foreach (Provider::orderBy('name')->get() as $company){
            $arr[$company->name] = $company->name;
        }
        return $arr;
    }
}
