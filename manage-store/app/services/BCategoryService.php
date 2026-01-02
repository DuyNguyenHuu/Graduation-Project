<?php
namespace App\Services;
use App\Models\BCategories;
use Illuminate\Support\Facades\DB;

class BCategoryService{
    public function getAll(){
        return DB::table('bcategories')->select('*')->get();
    }

    public function create(array $data){
        $bCategory = new BCategories();
        $bCategory->BCategory = $data['nameBCategory'];
        $bCategory->IdBCategory = $data['idBCategory'];
        $bCategory->StatusBCategory = $data['statusBCategory'];
        $bCategory->save();
        return $bCategory;
    }

    public function findById($idBCategory){
        return DB::table('bcategories')->where('IdBCategory', $idBCategory)->first();
    }

    public function update($idBCategory, array $data){
        return DB::table('bcategories')->where('idBCategory', $idBCategory)
            ->update([
                'BCategory' => $data['nameBCategory'],
                'IdBCategory' => $data['idBCategory'],
                'StatusBCategory' => $data['statusBCategory']
            ]);
    }

    public function delete($idBCategory){
        return DB::table('bcategories')->where('idBCategory', $idBCategory)
            ->delete();
    }
}