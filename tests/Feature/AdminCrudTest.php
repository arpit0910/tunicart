<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Coupon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function getAdminUser()
    {
        return User::factory()->create(['is_admin' => true]);
    }

    /* --- Category Tests --- */

    public function test_admin_can_access_categories_list_without_modals()
    {
        $admin = $this->getAdminUser();
        $category = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics'
        ]);

        $response = $this->actingAs($admin)->get(route('admin.categories'));
        $response->assertStatus(200);
        $response->assertSee('Electronics');
        $response->assertSee(route('admin.categories.create'));
        $response->assertSee(route('admin.categories.edit', $category->id));
        $response->assertDontSee('id="addModal"');
        $response->assertDontSee('id="editModal"');
    }

    public function test_admin_can_access_create_category_page()
    {
        $admin = $this->getAdminUser();
        $response = $this->actingAs($admin)->get(route('admin.categories.create'));
        $response->assertStatus(200);
        $response->assertSee('Add New Category');
    }

    public function test_admin_can_store_category()
    {
        Storage::fake('public');
        $admin = $this->getAdminUser();
        $file = UploadedFile::fake()->create('category.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'Fashion',
            'image' => $file
        ]);

        $response->assertRedirect(route('admin.categories'));
        $this->assertDatabaseHas('categories', [
            'name' => 'Fashion',
            'slug' => 'fashion'
        ]);

        $category = Category::where('name', 'Fashion')->first();
        Storage::disk('public')->assertExists($category->image);
    }

    public function test_admin_can_access_edit_category_page()
    {
        $admin = $this->getAdminUser();
        $category = Category::create([
            'name' => 'Home decor',
            'slug' => 'home-decor'
        ]);

        $response = $this->actingAs($admin)->get(route('admin.categories.edit', $category->id));
        $response->assertStatus(200);
        $response->assertSee('Edit Category');
        $response->assertSee('Home decor');
    }

    public function test_admin_can_update_category()
    {
        Storage::fake('public');
        $admin = $this->getAdminUser();
        $category = Category::create([
            'name' => 'Home decor',
            'slug' => 'home-decor'
        ]);

        $file = UploadedFile::fake()->create('category-new.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($admin)->post(route('admin.categories.update', $category->id), [
            'name' => 'Updated Home Decor',
            'image' => $file
        ]);

        $response->assertRedirect(route('admin.categories'));
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated Home Decor',
            'slug' => 'updated-home-decor'
        ]);

        $updatedCategory = Category::find($category->id);
        Storage::disk('public')->assertExists($updatedCategory->image);
    }

    public function test_admin_can_delete_category()
    {
        $admin = $this->getAdminUser();
        $category = Category::create([
            'name' => 'Delete Me',
            'slug' => 'delete-me'
        ]);

        $response = $this->actingAs($admin)->post(route('admin.categories.delete', $category->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    /* --- Product Tests --- */

    public function test_admin_can_access_products_list_without_modals()
    {
        $admin = $this->getAdminUser();
        $category = Category::create(['name' => 'Tech', 'slug' => 'tech']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Laptop X',
            'slug' => 'laptop-x',
            'price' => 999.99,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.products'));
        $response->assertStatus(200);
        $response->assertSee('Laptop X');
        $response->assertSee(route('admin.products.create'));
        $response->assertSee(route('admin.products.edit', $product->id));
        $response->assertDontSee('id="addModal"');
        $response->assertDontSee('id="editModal"');
    }

    public function test_admin_can_access_create_product_page()
    {
        $admin = $this->getAdminUser();
        $response = $this->actingAs($admin)->get(route('admin.products.create'));
        $response->assertStatus(200);
        $response->assertSee('Add New Product');
    }

    public function test_admin_can_store_product()
    {
        Storage::fake('public');
        $admin = $this->getAdminUser();
        $category = Category::create(['name' => 'Tech', 'slug' => 'tech']);
        $image = UploadedFile::fake()->create('prod.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'name' => 'Smart Watch',
            'price' => 199.99,
            'category_id' => $category->id,
            'description' => 'A great watch',
            'image' => $image
        ]);

        $response->assertRedirect(route('admin.products'));
        $this->assertDatabaseHas('products', [
            'name' => 'Smart Watch',
            'price' => 199.99,
            'category_id' => $category->id,
        ]);
    }

    public function test_admin_can_access_edit_product_page()
    {
        $admin = $this->getAdminUser();
        $category = Category::create(['name' => 'Tech', 'slug' => 'tech']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Old Product',
            'slug' => 'old-product',
            'price' => 10,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.products.edit', $product->id));
        $response->assertStatus(200);
        $response->assertSee('Edit Product');
        $response->assertSee('Old Product');
    }

    public function test_admin_can_update_product()
    {
        $admin = $this->getAdminUser();
        $category = Category::create(['name' => 'Tech', 'slug' => 'tech']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Old Product',
            'slug' => 'old-product',
            'price' => 10,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.products.update', $product->id), [
            'name' => 'New Product',
            'price' => 15,
            'category_id' => $category->id,
            'description' => 'Updated desc'
        ]);

        $response->assertRedirect(route('admin.products'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'New Product',
            'price' => 15,
        ]);
    }

    public function test_admin_can_delete_product()
    {
        $admin = $this->getAdminUser();
        $category = Category::create(['name' => 'Tech', 'slug' => 'tech']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'To Delete',
            'slug' => 'to-delete',
            'price' => 10,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.products.delete', $product->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /* --- Attribute Tests --- */

    public function test_admin_can_access_attributes_list_without_modals()
    {
        $admin = $this->getAdminUser();
        $attribute = Attribute::create(['name' => 'Color']);

        $response = $this->actingAs($admin)->get(route('admin.attributes'));
        $response->assertStatus(200);
        $response->assertSee('Color');
        $response->assertSee(route('admin.attributes.create'));
        $response->assertSee(route('admin.attributes.values.create', $attribute->id));
        $response->assertDontSee('id="attrModal"');
        $response->assertDontSee('id="valModal"');
    }

    public function test_admin_can_access_create_attribute_page()
    {
        $admin = $this->getAdminUser();
        $response = $this->actingAs($admin)->get(route('admin.attributes.create'));
        $response->assertStatus(200);
        $response->assertSee('Add Product Attribute');
    }

    public function test_admin_can_store_attribute()
    {
        $admin = $this->getAdminUser();
        $response = $this->actingAs($admin)->post(route('admin.attributes.store'), [
            'name' => 'Size'
        ]);

        $response->assertRedirect(route('admin.attributes'));
        $this->assertDatabaseHas('attributes', ['name' => 'Size']);
    }

    public function test_admin_can_access_create_attribute_value_page()
    {
        $admin = $this->getAdminUser();
        $attribute = Attribute::create(['name' => 'Size']);

        $response = $this->actingAs($admin)->get(route('admin.attributes.values.create', $attribute->id));
        $response->assertStatus(200);
        $response->assertSee('Add Value to Size');
    }

    public function test_admin_can_store_attribute_value()
    {
        $admin = $this->getAdminUser();
        $attribute = Attribute::create(['name' => 'Size']);

        $response = $this->actingAs($admin)->post(route('admin.attributes.values.store'), [
            'attribute_id' => $attribute->id,
            'value' => 'XL'
        ]);

        $response->assertRedirect(route('admin.attributes'));
        $this->assertDatabaseHas('attribute_values', [
            'attribute_id' => $attribute->id,
            'value' => 'XL'
        ]);
    }

    /* --- Testimonial Tests --- */

    public function test_admin_can_access_testimonials_list_without_modals()
    {
        $admin = $this->getAdminUser();
        $test = Testimonial::create([
            'user_name' => 'John Doe',
            'rating' => 5,
            'content' => 'Awesome service!'
        ]);

        $response = $this->actingAs($admin)->get(route('admin.testimonials'));
        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee(route('admin.testimonials.create'));
        $response->assertSee(route('admin.testimonials.edit', $test->id));
        $response->assertDontSee('id="addModal"');
        $response->assertDontSee('id="editModal"');
    }

    public function test_admin_can_access_create_testimonial_page()
    {
        $admin = $this->getAdminUser();
        $response = $this->actingAs($admin)->get(route('admin.testimonials.create'));
        $response->assertStatus(200);
        $response->assertSee('Add New Testimonial');
    }

    public function test_admin_can_store_testimonial()
    {
        $admin = $this->getAdminUser();
        $response = $this->actingAs($admin)->post(route('admin.testimonials.store'), [
            'user_name' => 'Jane Smith',
            'rating' => 4,
            'content' => 'Very good experience'
        ]);

        $response->assertRedirect(route('admin.testimonials'));
        $this->assertDatabaseHas('testimonials', [
            'user_name' => 'Jane Smith',
            'rating' => 4,
            'content' => 'Very good experience'
        ]);
    }

    public function test_admin_can_access_edit_testimonial_page()
    {
        $admin = $this->getAdminUser();
        $test = Testimonial::create([
            'user_name' => 'John Doe',
            'rating' => 5,
            'content' => 'Awesome service!'
        ]);

        $response = $this->actingAs($admin)->get(route('admin.testimonials.edit', $test->id));
        $response->assertStatus(200);
        $response->assertSee('Edit Testimonial');
        $response->assertSee('John Doe');
    }

    public function test_admin_can_update_testimonial()
    {
        $admin = $this->getAdminUser();
        $test = Testimonial::create([
            'user_name' => 'John Doe',
            'rating' => 5,
            'content' => 'Awesome service!'
        ]);

        $response = $this->actingAs($admin)->post(route('admin.testimonials.update', $test->id), [
            'user_name' => 'John Updated',
            'rating' => 3,
            'content' => 'Average service'
        ]);

        $response->assertRedirect(route('admin.testimonials'));
        $this->assertDatabaseHas('testimonials', [
            'id' => $test->id,
            'user_name' => 'John Updated',
            'rating' => 3,
        ]);
    }

    public function test_admin_can_delete_testimonial()
    {
        $admin = $this->getAdminUser();
        $test = Testimonial::create([
            'user_name' => 'John Doe',
            'rating' => 5,
            'content' => 'Awesome service!'
        ]);

        $response = $this->actingAs($admin)->post(route('admin.testimonials.delete', $test->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('testimonials', ['id' => $test->id]);
    }

    /* --- FAQ Tests --- */

    public function test_admin_can_access_faqs_list_without_modals()
    {
        $admin = $this->getAdminUser();
        $faq = Faq::create([
            'question' => 'How to return?',
            'answer' => 'Mail us details.'
        ]);

        $response = $this->actingAs($admin)->get(route('admin.faqs'));
        $response->assertStatus(200);
        $response->assertSee('How to return?');
        $response->assertSee(route('admin.faqs.create'));
        $response->assertSee(route('admin.faqs.edit', $faq->id));
        $response->assertDontSee('id="addModal"');
        $response->assertDontSee('id="editModal"');
    }

    public function test_admin_can_access_create_faq_page()
    {
        $admin = $this->getAdminUser();
        $response = $this->actingAs($admin)->get(route('admin.faqs.create'));
        $response->assertStatus(200);
        $response->assertSee('Add New FAQ');
    }

    public function test_admin_can_store_faq()
    {
        $admin = $this->getAdminUser();
        $response = $this->actingAs($admin)->post(route('admin.faqs.store'), [
            'question' => 'Is shipping free?',
            'answer' => 'Yes on orders above 999.'
        ]);

        $response->assertRedirect(route('admin.faqs'));
        $this->assertDatabaseHas('faqs', [
            'question' => 'Is shipping free?',
            'answer' => 'Yes on orders above 999.'
        ]);
    }

    public function test_admin_can_access_edit_faq_page()
    {
        $admin = $this->getAdminUser();
        $faq = Faq::create([
            'question' => 'How to return?',
            'answer' => 'Mail us details.'
        ]);

        $response = $this->actingAs($admin)->get(route('admin.faqs.edit', $faq->id));
        $response->assertStatus(200);
        $response->assertSee('Edit FAQ');
        $response->assertSee('How to return?');
    }

    public function test_admin_can_update_faq()
    {
        $admin = $this->getAdminUser();
        $faq = Faq::create([
            'question' => 'How to return?',
            'answer' => 'Mail us details.'
        ]);

        $response = $this->actingAs($admin)->post(route('admin.faqs.update', $faq->id), [
            'question' => 'How to return updated?',
            'answer' => 'Mail us details new.'
        ]);

        $response->assertRedirect(route('admin.faqs'));
        $this->assertDatabaseHas('faqs', [
            'id' => $faq->id,
            'question' => 'How to return updated?',
        ]);
    }

    public function test_admin_can_delete_faq()
    {
        $admin = $this->getAdminUser();
        $faq = Faq::create([
            'question' => 'How to return?',
            'answer' => 'Mail us details.'
        ]);

        $response = $this->actingAs($admin)->post(route('admin.faqs.delete', $faq->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
    }

    /* --- Coupon Tests --- */

    public function test_admin_can_access_coupons_list_without_modals()
    {
        $admin = $this->getAdminUser();
        $coupon = Coupon::create([
            'code' => 'DISCOUNT50',
            'type' => 'percent',
            'value' => 50,
            'min_amount' => 100,
            'status' => 1
        ]);

        $response = $this->actingAs($admin)->get(route('admin.coupons'));
        $response->assertStatus(200);
        $response->assertSee('DISCOUNT50');
        $response->assertSee(route('admin.coupons.create'));
        $response->assertSee(route('admin.coupons.edit', $coupon->id));
        $response->assertDontSee('id="addModal"');
        $response->assertDontSee('id="editModal"');
    }

    public function test_admin_can_access_create_coupon_page()
    {
        $admin = $this->getAdminUser();
        $response = $this->actingAs($admin)->get(route('admin.coupons.create'));
        $response->assertStatus(200);
        $response->assertSee('Create Coupon');
    }

    public function test_admin_can_store_coupon()
    {
        $admin = $this->getAdminUser();
        $response = $this->actingAs($admin)->post(route('admin.coupons.store'), [
            'code' => 'WELCOME10',
            'type' => 'percent',
            'value' => 10,
            'min_amount' => 0,
        ]);

        $response->assertRedirect(route('admin.coupons'));
        $this->assertDatabaseHas('coupons', [
            'code' => 'WELCOME10',
            'type' => 'percent',
            'value' => 10
        ]);
    }

    public function test_admin_can_access_edit_coupon_page()
    {
        $admin = $this->getAdminUser();
        $coupon = Coupon::create([
            'code' => 'DISCOUNT50',
            'type' => 'percent',
            'value' => 50,
            'min_amount' => 100,
            'status' => 1
        ]);

        $response = $this->actingAs($admin)->get(route('admin.coupons.edit', $coupon->id));
        $response->assertStatus(200);
        $response->assertSee('Edit Coupon');
        $response->assertSee('DISCOUNT50');
    }

    public function test_admin_can_update_coupon()
    {
        $admin = $this->getAdminUser();
        $coupon = Coupon::create([
            'code' => 'DISCOUNT50',
            'type' => 'percent',
            'value' => 50,
            'min_amount' => 100,
            'status' => 1
        ]);

        $response = $this->actingAs($admin)->post(route('admin.coupons.update', $coupon->id), [
            'code' => 'NEWDISCOUNT',
            'type' => 'fixed',
            'value' => 20,
            'min_amount' => 50,
            'status' => 0
        ]);

        $response->assertRedirect(route('admin.coupons'));
        $this->assertDatabaseHas('coupons', [
            'id' => $coupon->id,
            'code' => 'NEWDISCOUNT',
            'type' => 'fixed',
            'value' => 20,
            'status' => 0
        ]);
    }

    public function test_admin_can_delete_coupon()
    {
        $admin = $this->getAdminUser();
        $coupon = Coupon::create([
            'code' => 'DISCOUNT50',
            'type' => 'percent',
            'value' => 50,
            'min_amount' => 100,
            'status' => 1
        ]);

        $response = $this->actingAs($admin)->post(route('admin.coupons.delete', $coupon->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('coupons', ['id' => $coupon->id]);
    }
}
