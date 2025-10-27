<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function orderItems()
    {
        return $this->hasMany(Order_Items::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'u_id');
    }
}
