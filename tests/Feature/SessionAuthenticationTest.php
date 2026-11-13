<?php

namespace Tests\Feature;

use Tests\TestCase;

class SessionAuthenticationTest extends TestCase
{
    public function test_guest_can_open_login_page(): void
    {
        $this->get('/login')->assertOk()->assertSee('Masuk ke PWL POS');
    }

    public function test_guest_is_redirected_from_dashboard_to_login(): void
    {
        $this->get('/')->assertRedirect(route('login'));
    }

    public function test_guest_cannot_open_inventory_pages(): void
    {
        foreach (['/barang', '/kategori', '/stok', '/penjualan', '/user', '/level'] as $path) {
            $this->get($path)->assertRedirect(route('login'));
        }
    }
}
