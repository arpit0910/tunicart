<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\PaymentSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PaymentSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function getAdminUser()
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_non_admin_cannot_access_payment_settings()
    {
        $user = User::factory()->create(['is_admin' => false]);
        $response = $this->actingAs($user)->get(route('admin.payment-settings'));
        $response->assertRedirect('/');
    }

    public function test_admin_can_access_payment_settings()
    {
        $admin = $this->getAdminUser();
        $response = $this->actingAs($admin)->get(route('admin.payment-settings'));
        $response->assertStatus(200);
        $response->assertSee('Payment Settings');
        $response->assertSee('UPI Configurations');
        $response->assertSee('Bank Account Details');
    }

    public function test_admin_can_update_payment_settings()
    {
        Storage::fake('public');
        $admin = $this->getAdminUser();
        $qrCode = UploadedFile::fake()->create('qr.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($admin)->post(route('admin.payment-settings.update'), [
            'upi_id' => 'admin-merchant@upi',
            'upi_qr_code' => $qrCode,
            'bank_name' => 'Custom Bank of India',
            'account_holder' => 'Tunicart Custom Account',
            'account_number' => '9876543210123',
            'ifsc_code' => 'IFSC98765',
        ]);

        $response->assertRedirect(route('admin.payment-settings'));
        $this->assertDatabaseHas('payment_settings', [
            'id' => 1,
            'upi_id' => 'admin-merchant@upi',
            'bank_name' => 'Custom Bank of India',
            'account_holder' => 'Tunicart Custom Account',
            'account_number' => '9876543210123',
            'ifsc_code' => 'IFSC98765',
        ]);

        $settings = PaymentSetting::first();
        Storage::disk('public')->assertExists($settings->upi_qr_code);
    }

    public function test_checkout_payment_page_shows_dynamic_settings()
    {
        $user = User::factory()->create(['is_admin' => false]);

        // Seed settings
        PaymentSetting::firstOrCreate([
            'id' => 1
        ], [
            'upi_id' => 'checkout-pay@upi',
            'bank_name' => 'Checkout Test Bank',
            'account_holder' => 'Checkout Merchant Tunicart',
            'account_number' => '888877776666',
            'ifsc_code' => 'TESTBANK123',
        ]);

        // Add a category and product to allow cart checkout
        $category = Category::create(['name' => 'Teess', 'slug' => 'teess']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test T-Shirt',
            'slug' => 'test-t-shirt',
            'price' => 250.00,
            'stock' => 10,
        ]);

        // Place items in session cart
        $cart = [
            $product->id => [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ]
        ];

        // Store address details in checkout session
        $checkoutDetails = [
            'phone' => '1234567890',
            'shipping_address' => '123 Street Road',
            'city' => 'Tunicart City',
            'pincode' => '400001'
        ];

        $response = $this->withSession([
            'cart' => $cart,
        ])->actingAs($user)->post('/checkout/payment', $checkoutDetails);

        $response->assertStatus(200);
        $response->assertSee('checkout-pay@upi');
        $response->assertSee('Checkout Test Bank');
        $response->assertSee('Checkout Merchant Tunicart');
        $response->assertSee('888877776666');
        $response->assertSee('TESTBANK123');
    }
}
