<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use DB;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $rsetBarangMasuk = BarangMasuk::with('barang')->latest()->paginate(10);
        return view('view_barangmasuk.index', compact('rsetBarangMasuk'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }
    
    public function create()
    {
        $abarangmasuk = Barang::all();
        return view('view_barangmasuk.create',compact('abarangmasuk'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'tgl_masuk'     => 'required|date',
            'qty_masuk'     => 'required|numeric|min:1',
            'barang_id'     => 'required|exists:barang,id',
        ]);
    
        $tgl_masuk = $request->tgl_masuk;
        $barang_id = $request->barang_id;
    
        // Check if there's any BarangKeluar with a date earlier than tgl_masuk
        $existingBarangKeluar = BarangKeluar::where('barang_id', $barang_id)
            ->where('tgl_keluar', '<', $tgl_masuk)
            ->exists();
    
        if ($existingBarangKeluar) {
            return redirect()->back()->withInput()->withErrors(['tgl_masuk' => 'Tanggal masuk tidak boleh melebihi tanggal keluar!']);
        }
    
        BarangMasuk::create([
            'tgl_masuk'  => $tgl_masuk,
            'qty_masuk'  => $request->qty_masuk,
            'barang_id'  => $barang_id,
        ]);
    
        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Disimpan!']);
    } 

    public function show($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        return view('view_barangmasuk.show', compact('barangMasuk'));
    }

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangMasuk->delete();

        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }


    public function edit($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $abarangmasuk = Barang::all();

        return view('view_barangmasuk.edit', compact('barangMasuk', 'abarangmasuk'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'tgl_masuk'     => 'required|date',
            'qty_masuk'     => 'required|numeric|min:1',
            'barang_id'     => 'required|exists:barang,id',
        ]);
    
        $tgl_masuk = $request->tgl_masuk;
        $barang_id = $request->barang_id;
    
        // Check if there's any BarangKeluar with a date earlier than tgl_masuk
        $existingBarangKeluar = BarangKeluar::where('barang_id', $barang_id)
            ->where('tgl_keluar', '<', $tgl_masuk)
            ->exists();
    
        if ($existingBarangKeluar) {
            return redirect()->back()->withInput()->withErrors(['tgl_masuk' => 'Tanggal masuk tidak boleh melebihi tanggal keluar!']);
        }
    
        $barangMasuk = BarangMasuk::findOrFail($id);
    
        $barangMasuk->update([
            'tgl_masuk'  => $tgl_masuk,
            'qty_masuk'  => $request->qty_masuk,
            'barang_id'  => $barang_id,
        ]);
    
        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

}