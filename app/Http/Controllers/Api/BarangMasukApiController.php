<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;

class BarangMasukApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangmasuk = BarangMasuk::all();
        $data = array("data"=>$barangmasuk);

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tgl_masuk'     => 'required|date',
            'qty_masuk'     => 'required|numeric|min:1',
            //'barang_id'     => 'required|exists:barang,id',
        ]);
        
        $barangmasukbaru = BarangMasuk::create([
            'tgl_masuk'  => $tgl_masuk,
            'qty_masuk'  => $request->qty_masuk,
            //'barang_id'  => $barang_id,
        ]);

        $data = array("data"=>$barangmasukbaru);
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $barangmasuk = BarangMasuk::find($id);
        
        if(!$barangmasuk){
            return response()->json(['message' => 'Barang Masuk tidak ditemukan'], 404);
        }else{
            $data=array("data"=>$barangmasuk);
            return response()->json($data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $barangmasuk = BarangMasuk::find($id);

        $request->validate([
            'tgl_masuk'     => 'required|date',
            'qty_masuk'     => 'required|numeric|min:1',
            //'barang_id'     => 'required|exists:barang,id',
        ]);
        
        if (!$barangmasuk) {
            return response()->json(['status' => 'Barang Masuk tidak ditemukan'], 404);
        }else{
            $barangmasuk->update([
                'tgl_masuk'  => $tgl_masuk,
                'qty_masuk'  => $request->qty_masuk,
                //'barang_id'  => $barang_id,
            ]);

        return response()->json(['status' => 'Barang Masuk berhasil diubah'], 200);          
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barangmasuk = BarangMasuk::find($id);

        if (!$barangmasuk) {
            return response()->json(['status' => 'Barang Masuk tidak ditemukan'], 404);
        }
        
        try {
            $barangmasuk->delete();
            return response()->json(['status' => 'Barang Masuk berhasil dihapus'], 200);
        } catch (\Illuminate\Database\QueryException) {
            
            // Tangkap pengecualian spesifik dari database (termasuk constraints foreign key)
            return response()->json(['status' => 'Barang Masuk tidak dapat dihapus'], 500);
        }
    }
}
