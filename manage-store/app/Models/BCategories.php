<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BCategories extends Model
{
    protected $table = 'bcategories';
    protected $fillable = ['IdBCategory','BCategory','StatusBCategory', 'updated_at','created_at'];
}