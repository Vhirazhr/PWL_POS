<?php

namespace Tests\Feature;

use Tests\TestCase;

class PosAuthenticationTest extends TestCase
{
    public function test_login_page_is_available_to_guests(): void
    {
        $this->get('/login')->assertOk();
    }

    public function test_guest_is_redirected_from_protected_pos_pages_to_login(): void
    {
        $protectedPaths = [
            '/dashboard',
            '/profile',
            '/user',
            '/level',
            '/kategori',
            '/barang',
            '/stok',
            '/penjualan',
        ];

        foreach ($protectedPaths as $path) {
            $this->get($path)->assertRedirect(route('login'));
        }
    }

    public function test_public_home_remains_available_for_landing_page_work(): void
    {
        $this->get('/')->assertOk();
    }
}
