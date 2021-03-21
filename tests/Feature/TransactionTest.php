<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test that an authenticated user can make a transaction
     *
     * @return void
     */
    public function testStoreTransactionAuthenticated()
    {
        $product = Product::factory()->create();

        $user = User::factory()->create();
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $transaction = [
            'product_id' => $product->id,
            'quantity' => $product->quantity,
            'user_id' => $user->id,
        ];

        $response = $this->json('post', '/transaction', $transaction);

        $response->assertStatus(200);
        $this->assertDatabaseHas('transactions', [
            'product_id' => $product->id,
            'quantity' => $product->quantity,
            'user_id' => $user->id,
        ]);
    }


    /**
     * Test that an unauthenticated user cannot store a transaction
     */
    public function testStoreTransactionUnauthenticated()
    {
        $product = Product::factory()->create();

        $transaction = [
            'product_id' => $product->id,
            'quantity' => $product->quantity,
            'user_id' => 1,
        ];

        $response = $this->json('POST', '/transaction', $transaction);

        $response->assertStatus(401);
        $this->assertDatabaseMissing('transactions', [
            'product_id' => $product->id,
            'quantity' => $product->quantity,
            'user_id' => 1,
        ]);
    }


    /**
     * Test the error reporting when attempting to store a transaction with invalid data
     */
    public function testStoreTransactionError()
    {
        $product = Product::factory()->create();

        $user = User::factory()->create();
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $transaction = [
            'product_id' => $product->id + 1,
            'quantity' => $product->quantity + 1,
            'user_id' => $user->id,
        ];

        $response = $this->json('POST', '/transaction', $transaction);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'quantity', 'product_id'
        ]);
        $this->assertDatabaseMissing('transactions', [
            'product_id' => $product->id,
            'quantity' => $product->quantity,
            'user_id' => $user->id,
        ]);
    }


    /**
     * Test that an authenticated user can view all their transactions
     */
    public function testIndexTransactions()
    {
        $product = Product::factory()->create();

        $user = User::factory()->create();
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $transaction = [
            'product_id' => $product->id,
            'quantity' => $product->quantity,
            'user_id' => $user->id,
        ];

        $this->json('post', '/transaction', $transaction);
        $response = $this->get(route('transaction.index'));
        $response->assertSee($product->name);
    }
}
