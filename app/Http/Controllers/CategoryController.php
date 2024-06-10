<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Kategori;

class CategoryController extends Controller
{
    public function index(){
        //mengakses record table kategori semua record
        $rsetCategory= Kategori::all();

        // echo untuk menampilkan banyak data
        //cara bacanya : menampilkan banyak data pada object $rsetCategory di index 0 pada field deskripsi
        //echo $rsetCategory[0]->deskripsi;

        //retrun untuk menampilkan/mengembalikan satu data
        //cara bacanya : menampilkan/mengembalikan satu data pada object $rsetCategory di index 0 pada field deskripsi
        //return $rsetCategory[1]->deskripsi;

        //mengirim data ke view
        //parameter : path dan nama file view, object data yg dikirim
        // compact yaitu method
        //cara bacanya : menampilkan/mengembalikan ke view demo di dalam view_kategori dengan method compact rsetCategory
        return view('view_kategori.demo', compact('rsetCategory'));

        //return view('layouts.master');


    }
}
