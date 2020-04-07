<?php


namespace App\Repositories\Client;


use App\Contracts\Client\Query\QueryInterface;
use App\Helpers\ImageLinker;
use App\Helpers\TransJsonResponse;
use App\Contracts\Client\Product\ProductInterface;
use App\Contracts\FormatInterface;
use App\Models\Category\Category;
use App\Models\Category\ProductCategory;
use App\Models\Product\Product;
use App\Models\Provider\Provider;
use App\Models\Query\Query;
use phpDocumentor\Reflection\Types\Null_;

class QueryRepository implements QueryInterface
{

    public function index()
    {
        $queries = Query::whereNull('parent_id')
            ->get()
            ->map(function ($item){
            return $this->format($item);
        });;
        return TransJsonResponse::toJson(true, $queries,'Show all', 200);
    }

    public function format($data)
    {
        return [
            'id'        => $data->id,
            'query'     => $data->value,
            'answers'   => $data->answer ?? null,
        ];
    }
}
