<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    protected $table = 'blogs';
    protected $fillable = ['IdBlog', 'Blog', 'ImageBlog', 'DescriptionBlog', 'CategoryBlog', 'StatusBLog', 'updated_at','created_at'];
}