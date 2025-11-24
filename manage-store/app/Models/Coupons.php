<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    use HasFactory;
    protected $table='coupons';
    protected $fillable = ['IdCoupon', 'Title', 'Code', 'DiscountType', 'DiscountValue', 'StartTime', 'EndTime', 'Time', 'StatusCoupon', 'created_at', 'updated_at'];
}