<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSuccessfulOrder() {
        $login = [
            'email'      => 'jaskolski.jarod@yahoo.com',
            'password' => 'password',
        ];

        $user = $this->json('post', 'api/login', $login)
                ->assertStatus(201);

        $payload = [
            'product_id'    => 1,
            'quantity' => 1,
        ];
        $order = $this->withHeader('Authorization', 'Bearer ' . $user['data']['token'])
                ->json('post', 'api/order', $payload)
                ->assertStatus(201);

        echo PHP_EOL. $order['message'];
    }
    
    public function testFailedOrder() {
        $login = [
            'email'      => 'jaskolski.jarod@yahoo.com',
            'password' => 'password',
        ];

        $user = $this->json('post', 'api/login', $login)
                ->assertStatus(201);

        $payload = [
            'product_id'    => 1,
            'quantity' => 10000,
        ];
        $order = $this->withHeader('Authorization', 'Bearer ' . $user['data']['token'])
                ->json('post', 'api/order', $payload)
                ->assertStatus(400);

        echo PHP_EOL. $order['message'];
    }
}
