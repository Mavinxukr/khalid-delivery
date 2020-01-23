<?php


namespace App\Contracts\Client\Place;


use App\Contracts\FormatInterface;
use Illuminate\Support\Facades\Request;

interface PlaceInterface extends FormatInterface
{
    public function getAll(Request $request);
    public function store($data);
    public function format($data);

}
