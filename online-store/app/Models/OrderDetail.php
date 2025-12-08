<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'orderdetails';
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price', 'created_at', 'updated_at'];
}