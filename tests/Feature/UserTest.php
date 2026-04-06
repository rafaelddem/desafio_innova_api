<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create_successfully(): void
    {
        $userData = User::factory()->make()->toArray();
        $userData['password'] = $userData['password_confirmation'] = '123456';

        $this->post(route('store', $userData))
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'User successfully registered.',
                'username' => $userData['username'],
                'email' => $userData['email'],
            ]);

        unset($userData['password']);
        unset($userData['password_confirmation']);
        $this->assertDatabaseHas('users', $userData);
    }

    public function test_create_fail_without_data(): void
    {
        $this->post(route('store', []))
            ->assertStatus(422)
            ->assertExactJson([
                "message" => "Validation Exception",
                "errors" => [
                    "username" => [
                        "The username field is required."
                    ],
                    "email" => [
                        "The email field is required."
                    ],
                    "password" => [
                        "The password field is required."
                    ],
                    "hero_id" => [
                        "The hero id field is required."
                    ],
                    "role" => [
                        "The role field is required."
                    ],
                ],
            ]);
    }

    public function test_create_fail_duplicate_email_or_hero(): void
    {
        $userData = User::factory()->create()->toArray();
        $userData['password'] = $userData['password_confirmation'] = '123456';

        $this->post(route('store', $userData))
            ->assertStatus(422)
            ->assertExactJson([
                "message" => "Validation Exception",
                "errors" => [
                    "email" => [
                        "The email has already been taken."
                    ],
                    "hero_id" => [
                        "The hero id has already been taken."
                    ],
                ],
            ]);
    }

    public function test_create_fail_invalid_data(): void
    {
        $userData = User::factory()->make([
            'username' => substr(fake()->text(), 25, 30),
            'email' => substr(fake()->text(), 25, 30),
            'role' => 'fakeRole',
        ])->toArray();

        $userData['hero_id'] = 'fakeHero';
        $userData['password'] = $userData['password_confirmation'] = '123456';

        $this->post(route('store', $userData))
            ->assertStatus(422)
            ->assertExactJson([
                "message" => "Validation Exception",
                "errors" => [
                    "username" => [
                        "The username field must be between 3 and 20 characters."
                    ],
                    "email" => [
                        "The email field must be a valid email address."
                    ],
                    "role" => [
                        "The selected role is invalid."
                    ],
                    "hero_id" => [
                        "The hero id field must be a number."
                    ],
                ],
            ]);

        $userData = User::factory()->make([
            'username' => substr(fake()->text(), 0, 2),
            'hero_id' => 99999999999,
        ])->toArray();

        $userData['password'] = $userData['password_confirmation'] = '123456';

        $this->post(route('store', $userData))
            ->assertStatus(422)
            ->assertExactJson([
                "message" => "Validation Exception",
                "errors" => [
                    "username" => [
                        "The username field must be between 3 and 20 characters."
                    ],
                    "hero_id" => [
                        "The selected hero id is invalid."
                    ],
                ],
            ]);
    }

    public function test_show_user_successfully(): void
    {
        $user = User::factory()->create([ 'role' => Role::User->value ]);

        $this->actingAs($user)->get(route('user.show'))
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'User data',
                'username' => $user->username,
                'email' => $user->email,
            ]);
    }

    public function test_show_admin_successfully(): void
    {
        $admin = User::factory()->create([ 'role' => Role::Admin->value ]);

        $this->actingAs($admin)->get(route('user.show'))
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'User data',
                'username' => $admin->username,
                'email' => $admin->email,
            ]);
    }

    public function test_list_user_successfully(): void
    {
        $user = User::factory()->create([ 'role' => Role::User->value ]);

        $this->actingAs($user)->get(route('user.list'))
            ->assertStatus(403)
            ->assertJsonFragment([
                'message' => 'You do not have permission to access this resource.',
            ]);
    }

    public function test_list_admin_successfully(): void
    {
        $admin = User::factory()->create([ 'role' => Role::Admin->value ]);
        $user = User::factory()->create([ 'role' => Role::User->value ]);

        $this->actingAs($admin)->get(route('user.list'))
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'User data',
                'username' => $user->username,
                'email' => $user->email,
            ]);
    }

    public function test_update_user_successfully(): void
    {
        $user = User::factory()->create([ 'role' => Role::User->value ]);
        $userData = User::factory()->make([ 'role' => Role::User->value ])->toArray();
        $userData['password'] = $userData['password_confirmation'] = '123456789';
        unset($userData['email']);
        unset($userData['role']);

        $this->actingAs($user)->put(route('user.update', $userData))
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'User successfully updated.',
            ]);

        unset($userData['password']);
        unset($userData['password_confirmation']);
        $this->assertDatabaseHas('users', $userData);
    }

    public function test_update_admin_successfully(): void
    {
        $admin = User::factory()->create([ 'role' => Role::Admin->value ]);
        $adminData = User::factory()->make([ 'role' => Role::Admin->value ])->toArray();
        $adminData['password'] = $adminData['password_confirmation'] = '123456789';
        unset($adminData['email']);
        unset($adminData['role']);

        $this->actingAs($admin)->put(route('user.update', $adminData))
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'User successfully updated.',
            ]);

        unset($adminData['password']);
        unset($adminData['password_confirmation']);
        $this->assertDatabaseHas('users', $adminData);
    }

    public function test_update_fail_email_role(): void
    {
        $user = User::factory()->create([ 'role' => Role::User->value ]);
        $userData = User::factory()->make([ 'role' => Role::User->value ])->toArray();
        $userData['password'] = $userData['password_confirmation'] = '123456';

        $this->actingAs($user)->put(route('user.update', $userData))
            ->assertStatus(422)
            ->assertExactJson([
                "message" => "Validation Exception",
                "errors" => [
                    "email" => [
                        "The email field is prohibited."
                    ],
                    "role" => [
                        "The role field is prohibited."
                    ],
                ],
            ]);
    }

    public function test_update_fail_duplicate_email_or_hero(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $userData['hero_id'] = $user2->hero_id;

        $this->actingAs($user)->put(route('user.update', $userData))
            ->assertStatus(422)
            ->assertExactJson([
                "message" => "Validation Exception",
                "errors" => [
                    "hero_id" => [
                        "The hero id has already been taken."
                    ],
                ],
            ]);
    }

    public function test_update_fail_invalid_data(): void
    {
        $user = User::factory()->create();
        $userData['username'] = substr(fake()->text(), 25, 30);
        $userData['hero_id'] = 'fakeHero';

        $this->actingAs($user)->put(route('user.update', $userData))
            ->assertStatus(422)
            ->assertExactJson([
                "message" => "Validation Exception",
                "errors" => [
                    "username" => [
                        "The username field must be between 3 and 20 characters."
                    ],
                    "hero_id" => [
                        "The hero id field must be a number."
                    ],
                ],
            ]);

        $userData['username'] = substr(fake()->text(), 0, 2);
        $userData['hero_id'] = 999999999999;

        $this->actingAs($user)->put(route('user.update', $userData))
            ->assertStatus(422)
            ->assertExactJson([
                "message" => "Validation Exception",
                "errors" => [
                    "username" => [
                        "The username field must be between 3 and 20 characters."
                    ],
                    "hero_id" => [
                        "The selected hero id is invalid."
                    ],
                ],
            ]);
    }

    public function test_delete_admin_successfully(): void
    {
        $admin = User::factory()->create([ 'role' => Role::Admin->value ]);
        $token = JWTAuth::fromUser($admin);

        $this->withHeaders([ 'Authorization' => 'Bearer ' . $token ])->actingAs($admin)->delete(route('user.destroy'))
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'User successfully removed.',
            ]);
    }
}
