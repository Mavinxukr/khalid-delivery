<?php


namespace App\Contracts\Company\Service;


use App\Contracts\FormatInterface;
use Illuminate\Http\Request;

interface CompanyServiceInterface extends FormatInterface
{
    public function create(Request $request);

    public function storeSuggestCategory(Request $request);
}
