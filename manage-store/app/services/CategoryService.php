<?php

namespace App\Services;

use App\Models\Categories;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    public function getAll()
    {
        return DB::table('categories')->get();
    }

    public function create(array $data)
    {
        return Categories::create([
            'NameCategory' => $data['nameCategory'],
            'IdCategory'   => $data['idCategory'],
            'Status'       => $data['statusCategory'] ?? 1,
        ]);
    }

    public function findByIdCategory($idCategory)
    {
        return DB::table('categories')
            ->where('IdCategory', $idCategory)
            ->first();
    }

    public function update($idCategory, array $data)
    {
        return DB::table('categories')
            ->where('IdCategory', $idCategory)
            ->update([
                'NameCategory' => $data['nameCategory'],
                'IdCategory'   => $data['idCategory'],
                'Status'       => $data['statusCategory'],
            ]);
    }

    public function delete($idCategory)
    {
        return DB::table('categories')
            ->where('IdCategory', $idCategory)
            ->delete();
    }
}