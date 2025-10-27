<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class add_to_cart extends Model
{
    use HasFactory;
    protected $fillable = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'p_id');
    }
}