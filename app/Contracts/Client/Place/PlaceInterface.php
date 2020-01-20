<?php


namespace App\Contracts\Client\Place;


use Illuminate\Support\Facades\Request;

interface PlaceInterface
{
    public function getAll(Request $request);
    public function store($data);
    public function format($data);

}
