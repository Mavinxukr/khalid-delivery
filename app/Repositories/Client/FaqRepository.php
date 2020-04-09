<?php


namespace App\Repositories\Client;


use App\Contracts\Client\FAQ\FaqInterface;
use App\Helpers\TransJsonResponse;
use App\Models\FAQ\Faq;

class FaqRepository implements FaqInterface
{

    public function index()
    {
        $queries = Faq::whereNull('parent_id')
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
            'answer'    => $data->answer ?? null,
        ];
    }
}
