<?php

namespace Tests\Feature;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function test_authenticated_user_can_open_core_management_pages(): void
    {
        $user = $this->createTestUser();

        $this->actingAs($user, 'web');

        foreach ([
            '/dashboard',
            '/profile',
            '/profile/edit',
            '/user',
            '/level',
            '/kategori',
            '/barang',
            '/stok',
            '/penjualan',
        ] as $path) {
            $this->get($path)->assertOk();
        }
    }


    public function test_profile_image_supports_legacy_public_upload_paths(): void
    {
        $relativePath = 'uploads/profile/profile-test-'.uniqid().'.png';
        $absolutePath = public_path($relativePath);

        if (!is_dir(dirname($absolutePath))) {
            mkdir(dirname($absolutePath), 0755, true);
        }

        file_put_contents($absolutePath, 'legacy-profile-image');

        try {
            $user = new UserModel(['image' => $relativePath]);

            $this->assertSame(asset($relativePath), $user->image);
        } finally {
            @unlink($absolutePath);
        }
    }

    public function test_profile_image_uses_public_storage_for_new_uploads(): void
    {
        Storage::fake('public');
        $path = 'uploads/profile/new-profile.png';
        Storage::disk('public')->put($path, 'profile-image');

        $user = new UserModel(['image' => $path]);

        $this->assertSame(Storage::disk('public')->url($path), $user->image);
    }

    public function test_user_can_upload_and_display_a_profile_photo(): void
    {
        Storage::fake('public');
        $user = $this->createTestUser();
        $photo = UploadedFile::fake()->image('profile.png');

        $this->actingAs($user, 'web')
            ->put(route('profile.update'), [
                'nama' => 'Administrator Test',
                'image' => $photo,
            ])
            ->assertRedirect(route('profile'));

        $path = 'uploads/profile/'.$photo->hashName();
        Storage::disk('public')->assertExists($path);
        $this->assertDatabaseHas('m_user', [
            'user_id' => $user->user_id,
            'image' => $path,
        ]);

        $this->get(route('profile'))
            ->assertOk()
            ->assertSee(Storage::disk('public')->url($path));
    }

    public function test_public_home_displays_landing_page_for_guests(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertViewIs('welcome')
            ->assertSee('Kelola toko lebih')
            ->assertSee('Transaksi penjualan')
            ->assertSee(route('login'));
    }

    public function test_authenticated_user_visiting_home_is_redirected_to_dashboard(): void
    {
        $user = $this->createTestUser();

        $this->actingAs($user, 'web')
            ->get('/')
            ->assertRedirect(route('dashboard'));
    }
}
