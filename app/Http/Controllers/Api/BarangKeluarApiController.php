<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class BarangKeluarApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangkeluar = BarangKeluar::all();
        $data = array("data"=>$barangkeluar);

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tgl_keluar'     => 'required|date',
            'qty_keluar'     => 'required|numeric|min:1',
            //'barang_id'     => 'required|exists:barang,id',
        ]);
        
        $barangkeluarbaru = BarangKeluar::create([
            'tgl_keluar'  => $tgl_keluar,
            'qty_keluar'  => $request->qty_keluar,
            //'barang_id'  => $barang_id,
        ]);

        $data = array("data"=>$barangkeluarbaru);
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $barangkeluar = BarangKeluar::find($id);
        
        if(!$barangkeluar){
            return response()->json(['message' => 'Barang Keluar tidak ditemukan'], 404);
        }else{
            $data=array("data"=>$barangkeluar);
            return response()->json($data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $barangkeluar = BarangKeluar::find($id);

        $request->validate([
            'tgl_keluar'     => 'required|date',
            'qty_keluar'     => 'required|numeric|min:1',
            //'barang_id'     => 'required|exists:barang,id',
        ]);
        
        if (!$barangkeluar) {
            return response()->json(['status' => 'Barang Keluar tidak ditemukan'], 404);
        }else{
            $barangkeluar->update([
                'tgl_keluar'  => $tgl_keluar,
                'qty_keluar'  => $request->qty_keluar,
                //'barang_id'  => $barang_id,
            ]);

        return response()->json(['status' => 'Barang Keluar berhasil diubah'], 200);          
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barangkeluar = BarangKeluar::find($id);

        if (!$barangkeluar) {
            return response()->json(['status' => 'Barang Keluar tidak ditemukan'], 404);
        }
        
        try {
            $barangkeluar->delete();
            return response()->json(['status' => 'Barang Keluar berhasil dihapus'], 200);
        } catch (\Illuminate\Database\QueryException) {
            
            // Tangkap pengecualian spesifik dari database (terkeluar constraints foreign key)
            return response()->json(['status' => 'Barang Keluar tidak dapat dihapus'], 500);
        }
    }
}
