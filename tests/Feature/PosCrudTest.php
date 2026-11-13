<?php

namespace Tests\Feature;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\LevelModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use App\Models\StokModel;
use App\Models\UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PosCrudTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(): UserModel
    {
        $level = LevelModel::create([
            'level_kode' => 'ADM',
            'level_nama' => 'Administrator',
        ]);

        return UserModel::create([
            'level_id' => $level->level_id,
            'username' => 'admin-test',
            'nama' => 'Administrator Test',
            'password' => 'password123',
        ]);
    }

    private function createCategory(): KategoriModel
    {
        return KategoriModel::create([
            'kategori_kode' => 'ELE',
            'kategori_nama' => 'Elektronik',
        ]);
    }

    private function createProduct(KategoriModel $category): BarangModel
    {
        return BarangModel::create([
            'barang_kode' => 'BRG001',
            'barang_nama' => 'Mouse Wireless',
            'kategori_id' => $category->kategori_id,
            'harga_beli' => 50000,
            'harga_jual' => 75000,
        ]);
    }

    public function test_product_cannot_be_created_with_nonexistent_category(): void
    {
        $user = $this->createUser();

        $this->actingAs($user, 'web')
            ->from('/barang/create')
            ->post('/barang', [
                'barang_kode' => 'BRG001',
                'barang_nama' => 'Mouse Wireless',
                'kategori_id' => 9999,
                'harga_beli' => 50000,
                'harga_jual' => 75000,
            ])
            ->assertRedirect('/barang/create')
            ->assertSessionHasErrors('kategori_id');

        $this->assertDatabaseMissing('m_barang', ['barang_kode' => 'BRG001']);
    }

    public function test_stock_additions_accumulate_for_the_same_product(): void
    {
        $user = $this->createUser();
        $product = $this->createProduct($this->createCategory());

        $this->actingAs($user, 'web');

        $payload = [
            'barang_id' => $product->barang_id,
            'user_id' => $user->user_id,
            'stock_tanggal' => '2026-11-13 10:00:00',
            'stock_jumlah' => 5,
        ];

        $this->post('/stok', $payload)->assertRedirect('/stok');
        $this->post('/stok', array_merge($payload, [
            'stock_tanggal' => '2026-11-13 11:00:00',
            'stock_jumlah' => 3,
        ]))->assertRedirect('/stok');

        $this->assertSame(1, StokModel::where('barang_id', $product->barang_id)->count());
        $this->assertDatabaseHas('m_stock', [
            'barang_id' => $product->barang_id,
            'stock_jumlah' => 8,
            'stock_tanggal' => '2026-11-13 11:00:00',
        ]);
    }

    public function test_sale_uses_product_price_from_database_not_submitted_price(): void
    {
        $user = $this->createUser();
        $product = $this->createProduct($this->createCategory());

        $this->actingAs($user, 'web')
            ->post('/penjualan', [
                'user_id' => $user->user_id,
                'pembeli' => 'Pelanggan Test',
                'penjualan_kode' => 'TRX-TEST-001',
                'penjualan_tanggal' => '2026-11-13 12:00:00',
                'barang_id' => [$product->barang_id],
                'jumlah' => [2],
                'harga' => [1],
            ])
            ->assertRedirect(route('penjualan.index'));

        $sale = PenjualanModel::where('penjualan_kode', 'TRX-TEST-001')->firstOrFail();
        $detail = PenjualanDetailModel::where('penjualan_id', $sale->penjualan_id)->firstOrFail();

        $this->assertSame(75000, (int) $detail->harga);
        $this->assertSame(2, (int) $detail->jumlah);
    }
}
