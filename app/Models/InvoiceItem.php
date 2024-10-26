<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;
    protected $fillable = [
        "particulars",
        "qty",
        "rate",
        "vat",
        "amount",
        "net",
        "vat_perc"
    ] ;

    protected $casts = [
        'rate' => 'float',
        'vat' => 'float',
        'net' => 'float',
        'amount' => 'float',
        'qty' => 'integer',
        "vat_perc" => "float"
    ];
}

