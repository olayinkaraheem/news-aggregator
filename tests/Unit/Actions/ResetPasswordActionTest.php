<?php

use App\Models\User;
use App\Actions\ResetPasswordAction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('CreateUserAction class works as expected', function () {
    $user = User::factory()->create();
    
    $result = (new ResetPasswordAction())->handle(['user' => $user, 'password' => 'newpassword']);

    $this->assertTrue($result);
    $this->assertTrue(Hash::check('newpassword', $user->password));
})->group('actions');