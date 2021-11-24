<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Faker\Factory as Faker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function testUserIsCreatedSuccessfully() {
    
        $faker = Faker::create();
        $payload = [
            'email'      => $faker->email,
            'password' => 'test',
        ];

        $response = $this->json('post', 'api/register', $payload)
         ->assertStatus(201);

        echo $response['message'];
    }

    public function testSuccessfulLogin() {
    
        $faker = Faker::create();
        $payload = [
            'email'      => 'jaskolski.jarod@yahoo.com',
            'password' => 'password',
        ];

        $response = $this->json('post', 'api/login', $payload)
         ->assertStatus(201);

        echo PHP_EOL. $response['message'];
    }

    public function testFailedLogin() {
    
        $faker = Faker::create();
        $payload = [
            'email'      => 'jaskolski.jarod@yahoo.com',
            'password' => 'password1',
        ];

        $response = $this->json('post', 'api/login', $payload)
         ->assertStatus(401);

        echo PHP_EOL. $response['message'];
    }

}
