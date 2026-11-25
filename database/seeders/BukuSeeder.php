<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('buku')->insert([
            [
                'kode_buku' => 'BK-001',
                'judul' => 'Pemrograman Web Laravel Dasar',
                'penulis' => 'Eko Kurniawan',
                'kategori' => 'Teknologi',
                'stok' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_buku' => 'BK-002',
                'judul' => 'Algoritma dan Struktur Data',
                'penulis' => 'Rinaldi Munir',
                'kategori' => 'Ilmu Komputer',
                'stok' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_buku' => 'BK-003',
                'judul' => 'Basis Data Relasional & MySQL',
                'penulis' => 'Fathansyah',
                'kategori' => 'Basis Data',
                'stok' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_buku' => 'BK-004',
                'judul' => 'Jaringan Komputer Berbasis Cisco',
                'penulis' => 'Melwin Syafrizal',
                'kategori' => 'Jaringan',
                'stok' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_buku' => 'BK-005',
                'judul' => 'Desain Antarmuka Pengguna (UI/UX)',
                'penulis' => 'Andi Offset',
                'kategori' => 'Desain',
                'stok' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_buku' => 'BK-006',
                'judul' => 'Manajemen Proyek Perangkat Lunak',
                'penulis' => 'Rosa A.S.',
                'kategori' => 'Manajemen',
                'stok' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_buku' => 'BK-007',
                'judul' => 'Sistem Informasi Manajemen Kota',
                'penulis' => 'Budi Rahardjo',
                'kategori' => 'Smart City',
                'stok' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_buku' => 'BK-008',
                'judul' => 'Pemrograman Berorientasi Objek Java',
                'penulis' => 'Munawar',
                'kategori' => 'Pemrograman',
                'stok' => 14,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_buku' => 'BK-009',
                'judul' => 'Pengantar Statistika untuk IT',
                'penulis' => 'Sugiyono',
                'kategori' => 'Matematika',
                'stok' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_buku' => 'BK-010',
                'judul' => 'Keamanan Sistem Informasi & Jaringan',
                'penulis' => 'Onno W. Purbo',
                'kategori' => 'Keamanan',
                'stok' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}