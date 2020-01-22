<?php


namespace App\Contracts\Company\Place;


use App\Contracts\FormatInterface;
use Illuminate\Http\Request;

interface PlaceInterface
{
    public function store(Request $request);

}
