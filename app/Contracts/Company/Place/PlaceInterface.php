<?php


namespace App\Contracts\Company\Place;


use App\Contracts\FormatInterface;
use Illuminate\Http\Request;

interface PlaceInterface extends  FormatInterface
{
    public function store(Request $request);

    public function getCompanyGeo(Request $request);

}
