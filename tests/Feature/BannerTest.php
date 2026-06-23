<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Banner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BannerTest extends TestCase
{
    use RefreshDatabase;

    protected function getAdminUser()
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_non_admin_cannot_access_banners()
    {
        $user = User::factory()->create(['is_admin' => false]);
        $response = $this->actingAs($user)->get(route('admin.banners'));
        $response->assertRedirect('/');
    }

    public function test_admin_can_access_banners_list()
    {
        $admin = $this->getAdminUser();
        $banner = Banner::create([
            'image' => 'banners/dummy.jpg',
            'title' => 'Test Banner Title',
            'sub_title' => 'Test Sub Title',
            'display_on' => 'both',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.banners'));
        $response->assertStatus(200);
        $response->assertSee('Test Banner Title');
        $response->assertSee('Test Sub Title');
        $response->assertSee(route('admin.banners.create'));
        $response->assertSee(route('admin.banners.edit', $banner->id));
        $response->assertDontSee('id="addModal"');
        $response->assertDontSee('id="editModal"');
    }

    public function test_admin_can_access_create_banner_page()
    {
        $admin = $this->getAdminUser();
        $response = $this->actingAs($admin)->get(route('admin.banners.create'));
        $response->assertStatus(200);
        $response->assertSee('Add New Hero Banner');
    }

    public function test_admin_can_store_banner()
    {
        Storage::fake('public');
        $admin = $this->getAdminUser();

        $file = UploadedFile::fake()->create('banner.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($admin)->post(route('admin.banners.store'), [
            'image' => $file,
            'title' => 'New Banner Title',
            'sub_title' => 'New Sub Title',
            'description' => 'New Description',
            'button_text' => 'Shop Here',
            'text_color' => '#ffffff',
            'display_on' => 'web',
            'link' => 'https://example.com',
            'vertical_position' => 'center',
            'horizontal_position' => 'center',
            'text_align' => 'center',
        ]);

        $response->assertRedirect(route('admin.banners'));
        $this->assertDatabaseHas('banners', [
            'title' => 'New Banner Title',
            'sub_title' => 'New Sub Title',
            'description' => 'New Description',
            'button_text' => 'Shop Here',
            'text_color' => '#ffffff',
            'display_on' => 'web',
            'link' => 'https://example.com',
            'vertical_position' => 'center',
            'horizontal_position' => 'center',
            'text_align' => 'center',
        ]);
        
        $banner = Banner::first();
        Storage::disk('public')->assertExists($banner->image);
    }

    public function test_admin_can_access_edit_banner_page()
    {
        $admin = $this->getAdminUser();
        $banner = Banner::create([
            'image' => 'banners/dummy.jpg',
            'title' => 'Old Title',
            'sub_title' => 'Old Sub',
            'display_on' => 'both',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.banners.edit', $banner->id));
        $response->assertStatus(200);
        $response->assertSee('Edit Hero Banner');
        $response->assertSee('Old Title');
        $response->assertSee('Old Sub');
    }

    public function test_admin_can_update_banner()
    {
        Storage::fake('public');
        $admin = $this->getAdminUser();
        $banner = Banner::create([
            'image' => 'banners/old.jpg',
            'title' => 'Old Title',
            'sub_title' => 'Old Sub',
            'display_on' => 'both',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.banners.update', $banner->id), [
            'title' => 'Updated Title',
            'sub_title' => 'Updated Sub',
            'description' => 'Updated Description',
            'button_text' => 'Updated Button',
            'text_color' => '#000000',
            'display_on' => 'mobile',
            'link' => 'https://updated.com',
            'vertical_position' => 'flex-end',
            'horizontal_position' => 'flex-end',
            'text_align' => 'right',
        ]);

        $response->assertRedirect(route('admin.banners'));
        $this->assertDatabaseHas('banners', [
            'id' => $banner->id,
            'title' => 'Updated Title',
            'sub_title' => 'Updated Sub',
            'display_on' => 'mobile',
            'link' => 'https://updated.com',
        ]);
    }

    public function test_admin_can_delete_banner()
    {
        $admin = $this->getAdminUser();
        $banner = Banner::create([
            'image' => 'banners/dummy.jpg',
            'title' => 'To Be Deleted',
            'display_on' => 'both',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.banners.delete', $banner->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('banners', [
            'id' => $banner->id,
        ]);
    }

    public function test_admin_is_redirected_to_admin_dashboard_from_customer_dashboard()
    {
        $admin = $this->getAdminUser();
        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_customer_is_not_redirected_from_customer_dashboard()
    {
        $customer = User::factory()->create(['is_admin' => false]);
        $response = $this->actingAs($customer)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Total Orders');
    }

    public function test_authenticated_admin_is_redirected_to_admin_dashboard_from_login_page()
    {
        $admin = $this->getAdminUser();
        $response = $this->actingAs($admin)->get('/login');
        $response->assertRedirect(route('admin.dashboard'));
    }
}
