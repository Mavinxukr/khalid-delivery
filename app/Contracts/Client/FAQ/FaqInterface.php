<?php


namespace App\Contracts\Client\FAQ;

use App\Contracts\FormatInterface;

interface FaqInterface extends FormatInterface
{
    public function index();
}
