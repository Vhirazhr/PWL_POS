<?php

namespace Tests\Feature;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PosAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private function createTestUser(): UserModel
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

    public function test_login_page_is_available_to_guests(): void
    {
        $this->get('/login')->assertOk();
    }

    public function test_valid_user_can_log_in_and_reach_dashboard(): void
    {
        $user = $this->createTestUser();

        $this->post(route('login.submit'), [
            'username' => 'admin-test',
            'password' => 'password123',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user, 'web');
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        $this->createTestUser();

        $this->from('/login')->post(route('login.submit'), [
            'username' => 'admin-test',
            'password' => 'wrong-password',
        ])->assertRedirect('/login')->assertSessionHasErrors('username');

        $this->assertGuest('web');
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

    public function test_authenticated_user_can_log_out(): void
    {
        $user = $this->createTestUser();

        $this->actingAs($user, 'web')
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest('web');
    }

    public function test_authenticated_user_can_view_dashboard_summary(): void
    {
        $user = $this->createTestUser();

        $this->actingAs($user, 'web')
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Transaksi Terbaru')
            ->assertSee('Barang Terdaftar');
    }

    public function test_public_home_redirects_guests_to_login(): void
    {
        $this->get('/')
            ->assertRedirect(route('login'));
    }
}
