<?php


namespace App\Contracts\Company\Service;


use Illuminate\Http\Request;

interface CompanyServiceInterface
{
    public function create(Request $request);
}
