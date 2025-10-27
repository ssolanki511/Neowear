<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'o_name',
        'o_offer',
        'max_price',
        'min_price',
        'o_status'
    ];
}
