<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    use HasFactory;
    protected $table='options';
    protected $fillable=['OptionProduct', 'SubOption', 'IdProduct_Option', 'Quantity', 'BonusPrice', 'updated_at', 'created_at'];
}