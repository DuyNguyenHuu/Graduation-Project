<?php

namespace App\Services;

use App\Models\SubCategories;
use Illuminate\Support\Facades\DB;

class SubCategoryService
{
    public function getAll()
    {
        return DB::table('subcategories')
            ->join('categories', 'subcategories.IdSubCategory', '=', 'categories.IdCategory')
            ->orderBy('categories.IdCategory', 'asc')
            ->select('subcategories.*', 'categories.NameCategory')
            ->get();
    }

    public function getCategories()
    {
        return DB::table('categories')->get();
    }

    public function create(array $data)
    {
        return SubCategories::create([
            'IdSub'         => $data['idSubCategory'],
            'Name'          => $data['nameSubCategory'],
            'IdSubCategory' => $data['idCategory'],
            'StatusSub'     => $data['statusSub'],
        ]);
    }

    public function find($idSub, $idCategory)
    {
        return DB::table('subcategories')
            ->join('categories', 'subcategories.IdSubCategory', '=', 'categories.IdCategory')
            ->where('IdSub', $idSub)
            ->where('IdSubCategory', $idCategory)
            ->first();
    }

    public function update($idSub, $idCategory, array $data)
    {
        return DB::table('subcategories')
            ->where('IdSub', $idSub)
            ->where('IdSubCategory', $idCategory)
            ->update([
                'IdSub'         => $data['idSubCategory'],
                'Name'          => $data['nameSubCategory'],
                'IdSubCategory' => $data['nameCategory'],
                'StatusSub'     => $data['statusSubCategory'],
            ]);
    }

    public function delete($idSub, $idCategory)
    {
        return DB::table('subcategories')
            ->where('IdSub', $idSub)
            ->where('IdSubCategory', $idCategory)
            ->delete();
    }
}