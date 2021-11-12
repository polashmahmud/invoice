<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['customer', 'invoice_no', 'invoice_date', 'invoice_due_date', 'products', 'notes', 'files'];

    protected $casts = [
        'products' => 'array',
        'customer' => 'array',
        'files'    => 'array',
    ];
}
