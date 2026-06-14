<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_buyer_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Buyer',
            'email' => 'testbuyer@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'buyer',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('products.index', absolute: false));

        $user = User::where('email', 'testbuyer@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('buyer', $user->role);
        $this->assertTrue($user->isBuyer());
        $this->assertFalse($user->isSeller());
    }

    public function test_seller_can_register_with_store_name(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Seller',
            'email' => 'testseller@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'seller',
            'store_name' => 'Test Store',
            'store_description' => 'A test store description',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('seller.dashboard', absolute: false));

        $user = User::where('email', 'testseller@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('seller', $user->role);
        $this->assertEquals('Test Store', $user->store_name);
        $this->assertTrue($user->isSeller());
        $this->assertFalse($user->isBuyer());
    }

    public function test_seller_registration_requires_store_name(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Seller',
            'email' => 'testseller@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'seller',
            // store_name intentionally omitted
        ]);

        $response->assertSessionHasErrors('store_name');
    }

    public function test_registration_rejects_invalid_role(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'admin', // invalid
        ]);

        $response->assertSessionHasErrors('role');
    }
}
