<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;

class InvoiceTemplate extends Model
{
    protected $fillable = [
        'title', 'value', 'key',
    ];
}
