<?php

namespace Tests\Feature\Perpustakaan;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Perpustakaan\Models\Buku;
use Tests\TestCase;

class BukuAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_petugas_cannot_load_edit_form_or_update_a_book(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);
        $buku = Buku::create([
            'kode_buku' => 'BK-001',
            'judul' => 'Judul Awal',
            'penulis' => 'Penulis Awal',
            'kategori' => 'Umum',
            'stok' => 3,
        ]);

        $this->actingAs($petugas)
            ->getJson(route('perpustakaan.edit', $buku->id))
            ->assertForbidden()
            ->assertJson(['success' => false]);

        $this->actingAs($petugas)
            ->putJson(route('perpustakaan.update', $buku->id), [
                'kode_buku' => 'BK-001',
                'judul' => 'Judul Diubah',
                'penulis' => 'Penulis Awal',
                'kategori' => 'Umum',
                'stok' => 3,
            ])
            ->assertForbidden()
            ->assertJson(['success' => false]);

        $this->assertSame('Judul Awal', $buku->fresh()->judul);
    }

    public function test_admin_can_load_edit_form_and_update_a_book(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $buku = Buku::create([
            'kode_buku' => 'BK-002',
            'judul' => 'Judul Awal',
            'penulis' => 'Penulis Awal',
            'kategori' => 'Umum',
            'stok' => 3,
        ]);

        $this->actingAs($admin)
            ->getJson(route('perpustakaan.edit', $buku->id))
            ->assertOk()
            ->assertJson(['judul' => 'Judul Awal']);

        $this->putJson(route('perpustakaan.update', $buku->id), [
            'kode_buku' => 'BK-002',
            'judul' => 'Judul Baru',
            'penulis' => 'Penulis Baru',
            'kategori' => 'Referensi',
            'stok' => 5,
        ])
            ->assertOk()
            ->assertJson(['success' => true]);

        $this->assertSame('Judul Baru', $buku->fresh()->judul);
    }
}
