<?php


namespace App\Contracts\Client\Query;

use App\Contracts\FormatInterface;

interface QueryInterface extends FormatInterface
{
    public function index();
}
