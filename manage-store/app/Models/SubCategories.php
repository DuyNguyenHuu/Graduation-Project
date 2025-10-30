<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategories extends Model
{
    use HasFactory;
    protected $table = 'subcategories';
    protected $fillable = ['IdSub', 'Name', 'IdSubCategory', 'StatusSub', 'updated_at', 'created_at'];
}