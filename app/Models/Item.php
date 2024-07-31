<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'brand',
        'sn',
        'code',
        'status',
        'condition',
        'procurement_date',
        'description',
        'is_used',
        'unit',
        'sub_unit',
        'user',
        'sap_number',
    ];
}
