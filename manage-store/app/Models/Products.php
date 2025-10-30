<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table='products';
    protected $fillable = ['IdProduct', 'NameProduct', 'TypeProduct', 'NewPrice', 'OldPrice', 'Status', 'ImageURL', 'Description', 'Category', 'SubCategory', 'updated_at', 'created_at'];
}