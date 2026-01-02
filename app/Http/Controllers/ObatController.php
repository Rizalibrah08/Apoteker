<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Obat::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_obat', 'like', "%{$search}%")
                    ->orWhere('kode_obat', 'like', "%{$search}%");
            });
        }

        // Filter Category
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $obats = $query->get();
        return view('backend.obat.index', compact('obats'));
    }

    public function create()
    {
        return view('backend.obat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_obat' => 'required|unique:obats,kode_obat',
            'nama_obat' => 'required|unique:obats,nama_obat',
            'kategori' => 'required',
            'stok' => 'required|integer|min:2',
            'satuan' => 'required',
            'harga' => 'required|integer',
            'expired_date' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_obat.unique' => 'Nama obat ini sudah terdaftar!',
            'stok.min' => 'Stok minimal harus 2 barang!',
        ]);

        $input = $request->all();

        if ($image = $request->file('gambar')) {
            $destinationPath = 'images/obat/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['gambar'] = "$profileImage";
        }

        \App\Models\Obat::create($input);

        return redirect()->route('obat.index')
            ->with('success', 'Obat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $obat = \App\Models\Obat::find($id);
        return view('backend.obat.edit', compact('obat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_obat' => 'required|unique:obats,kode_obat,' . $id,
            'nama_obat' => 'required|unique:obats,nama_obat,' . $id,
            'kategori' => 'required',
            'stok' => 'required|integer|min:0', // Update minimal shouldn't be strictly 2 maybe? User said "saat menambah barang". Assuming standard validation for update.
            'satuan' => 'required',
            'harga' => 'required|integer',
            'expired_date' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_obat.unique' => 'Nama obat ini sudah terdaftar!',
        ]);

        $obat = \App\Models\Obat::find($id);
        $input = $request->all();

        if ($image = $request->file('gambar')) {
            $destinationPath = 'images/obat/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['gambar'] = "$profileImage";
        } else {
            unset($input['gambar']);
        }

        $obat->update($input);

        return redirect()->route('obat.index')
            ->with('success', 'Data obat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        \App\Models\Obat::find($id)->delete();
        return redirect()->route('obat.index')
            ->with('success', 'Obat berhasil dihapus.');
    }


}
