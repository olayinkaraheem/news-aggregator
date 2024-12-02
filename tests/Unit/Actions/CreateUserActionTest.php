<?php

use App\Actions\CreateUserAction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
uses(WithFaker::class);

test('CreateUserAction class works as expected', function () {
    $data = [
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'password' => Hash::make('password')
    ];
    
    $result = (new CreateUserAction())->handle($data);

    $this->assertTrue($result);
    $this->assertDatabaseHas('users', $data);
})->group('actions');
