<?php

namespace Modules\Perpustakaan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Perpustakaan\Models\Buku;

class PerpustakaanController extends Controller
{
    // 1. Menampilkan Halaman utama Data Buku (Read)
    public function index()
    {
        $buku = Buku::all();
        return view('perpustakaan::index', compact('buku'));
    }

    // 2. Menyimpan Data Buku Baru (Create - AJAX)
    public function store(Request $request)
    {
        $request->validate([
            'kode_buku' => 'required|unique:buku,kode_buku|max:20',
            'judul'     => 'required|string|max:150',
            'penulis'   => 'required|string|max:100',
            'kategori'  => 'required|string|max:50',
            'stok'      => 'required|integer|min:0', // Stok tidak boleh negatif
        ]);

        $buku = Buku::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data buku berhasil ditambahkan!',
            'data'    => $buku
        ]);
    }

    // 3. Mengambil Data Buku untuk Modal Edit (JSON)
    public function edit(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak! Hanya Admin yang dapat mengubah data.'], 403);
        }

        $buku = Buku::findOrFail($id);
        return response()->json($buku);
    }

    // 4. Memperbarui Data Buku (Update - AJAX)
    // Tambahkan proteksi hak akses di method update dan destroy

    public function update(Request $request, $id)
    {
        // Menggunakan $request->user() membuat VS Code Intelephense mengenali objek user tanpa error
        $user = $request->user();

        // Cek Hak Akses: Hanya Admin yang boleh mengubah data
        if ($user->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak! Hanya Admin yang dapat mengubah data.'], 403);
        }

        $buku = Buku::findOrFail($id);

        $validated = $request->validate([
            'kode_buku' => 'required|max:20|unique:buku,kode_buku,' . $id,
            'judul'     => 'required|string|max:150',
            'penulis'   => 'required|string|max:100',
            'kategori'  => 'required|string|max:50',
            'stok'      => 'required|integer|min:0',
        ]);

        $buku->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data buku berhasil diperbarui!',
            'data'    => $buku
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        // Cek Hak Akses: Hanya Admin yang boleh menghapus data
        if ($user->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak! Hanya Admin yang dapat menghapus data.'], 403);
        }

        $buku = Buku::findOrFail($id);
        $buku->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data buku berhasil dihapus!'
        ]);
    }
}