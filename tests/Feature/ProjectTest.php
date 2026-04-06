<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProjectTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create_successfully(): void
    {
        $admin = User::factory()->create([ 'role' => Role::Admin->value ]);

        $projectData = Project::factory()->make()->toArray();

        $this->actingAs($admin)->post(route('project.store', $projectData))
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Project successfully registered.',
                'name' => $projectData['name'],
                'description' => $projectData['description'],
                'status' => $projectData['status'],
            ]);
    }

    public function test_create_fail_without_data(): void
    {
        $admin = User::factory()->create([ 'role' => Role::Admin->value ]);

        $this->actingAs($admin)->post(route('project.store', []))
            ->assertStatus(422)
            ->assertExactJson([
                "message" => "Validation Exception",
                "errors" => [
                    "name" => [
                        "The name field is required."
                    ],
                    "description" => [
                        "The description field is required."
                    ],
                    "status" => [
                        "The status field is required."
                    ],
                    "goals" => [
                        "The goals field is required."
                    ],
                    "user_id" => [
                        "The user id field is required."
                    ],
                ],
            ]);
    }

    public function test_create_fail_invalid_data(): void
    {
        $admin = User::factory()->create([ 'role' => Role::Admin->value ]);

        $projectData = Project::factory()->make([
            'name' => substr(fake()->text(), 21, 25),
            'description' => fake()->text(450),
            'goals' => fake()->text(400),
        ])->toArray();
        $projectData['user_id'] = 'fakeUser';
        $projectData['status'] = 'fakeStatus';

        $this->actingAs($admin)->post(route('project.store', $projectData))
            ->assertStatus(422)
            ->assertExactJson([
                "message" => "Validation Exception",
                "errors" => [
                    "name" => [
                        "The name field must be between 3 and 20 characters."
                    ],
                    "description" => [
                        "The description field must not be greater than 255 characters."
                    ],
                    "goals" => [
                        "The goals field must not be greater than 150 characters."
                    ],
                    "status" => [
                        "The selected status is invalid."
                    ],
                    "user_id" => [
                        "The user id field must be a number."
                    ],
                ],
            ]);

        $projectData = Project::factory()->make([
            'name' => substr(fake()->text(), 1, 2),
            'user_id' => 99999999,
        ])->toArray();

        $this->actingAs($admin)->post(route('project.store', $projectData))
            ->assertStatus(422)
            ->assertExactJson([
                "message" => "Validation Exception",
                "errors" => [
                    "name" => [
                        "The name field must be between 3 and 20 characters."
                    ],
                    "user_id" => [
                        "The selected user id is invalid."
                    ],
                ],
            ]);
    }

    public function test_list_user_successfully(): void
    {
        $user = User::factory()->create([ 'role' => Role::User->value ]);
        Project::factory()->create();
        Project::factory()->create([
            "user_id" => $user->id,
        ]);

        $response = $this->actingAs($user)->get(route('project.list'))
            ->assertStatus(200)
            ->assertJsonPath('message', 'List of projects');

        $this->assertIsArray($response->json('projects'));
        $this->assertCount(1, $response->json('projects'));
    }

    public function test_list_admin_successfully(): void
    {
        $admin = User::factory()->create([ 'role' => Role::Admin->value ]);
        Project::factory()->create();
        Project::factory()->create();

        $response = $this->actingAs($admin)->get(route('project.list'))
            ->assertStatus(200)
            ->assertJsonPath('message', 'List of projects');

        $this->assertIsArray($response->json('projects'));
        $this->assertTrue($response->json('projects') > 0);
    }

    public function test_show_user_successfully(): void
    {
        $user = User::factory()->create([ 'role' => Role::User->value ]);
        $project = Project::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)->get(route('project.show', ['id' => $project->id]))
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Project data.',
                'name' => $project->name,
            ]);
    }

    public function test_show_fail_user_unauthorized(): void
    {
        $user = User::factory()->create([ 'role' => Role::User->value ]);
        $project = Project::factory()->create();

        $this->actingAs($user)->get(route('project.show', ['id' => $project->id]))
            ->assertStatus(401)
            ->assertJsonPath('message', 'The reported record was not found.');
    }

    public function test_show_admin_successfully(): void
    {
        $admin = User::factory()->create([ 'role' => Role::Admin->value ]);
        $project = Project::factory()->create();

        $this->actingAs($admin)->get(route('project.show', ['id' => $project->id]))
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Project data.',
                'name' => $project->name,
            ]);
    }

    public function test_update_admin_successfully(): void
    {
        $admin = User::factory()->create([ 'role' => Role::Admin->value ]);

        $project = Project::factory()->create();
        $projectData = Project::factory()->make()->toArray();
        $projectData['id'] = $project->id;

        $this->actingAs($admin)->put(route('project.update', $projectData))
            ->assertStatus(200)
            ->assertExactJson([
                'message' => 'Project successfully updated.',
                "project" => [
                    "id" => (int) $projectData['id'],
                    "name" => $projectData['name'],
                    "description" => $projectData['description'],
                    "status" => $projectData['status'],
                    "goals" => $projectData['goals'],
                    "user_id" => (string) $projectData['user_id'],
                    "hero_name" => (string) $project->user->hero_name,
                ],
            ]);
    }

    public function test_update_user_successfully(): void
    {
        $user = User::factory()->create([ 'role' => Role::User->value ]);

        $project = Project::factory()->create([ 'user_id' => $user->id ]);
        $projectData = [
            'id' => $project->id,
            'goals' => $project->goals,
            'status' => $project->status,
        ];

        $this->actingAs($user)->put(route('project.update', $projectData))
            ->assertStatus(200)
            ->assertExactJson([
                'message' => 'Project successfully updated.',
                "project" => [
                    "status" => $projectData['status'],
                    "goals" => trim($projectData['goals']),
                    "id" => $project->id,
                    "name" => $project->name,
                    "description" => $project->description,
                    "user_id" => $project->user_id,
                    "hero_name" => (string) $user->hero_name,
                ],
            ]);
    }

    public function test_update_user_fail(): void
    {
        $user = User::factory()->create([ 'role' => Role::User->value ]);

        $project = Project::factory()->create();
        $projectData = Project::factory()->make()->toArray();
        $projectData['id'] = $project->id;

        $this->actingAs($user)->put(route('project.update', $projectData))
            ->assertStatus(401)
            ->assertJsonFragment([
                'message' => 'You do not have permission to access this resource.',
            ]);
    }

    public function test_update_fail_invalid_data(): void
    {
        $admin = User::factory()->create([ 'role' => Role::Admin->value ]);

        $project = Project::factory()->create([ 'user_id' => $admin->id ]);
        $projectData = Project::factory()->make([
            'name' => substr(fake()->text(), 21, 25),
            'description' => fake()->text(450),
            'goals' => fake()->text(400),
        ])->toArray();
        // $projectData['user_id'] = 'a';
        $projectData['status'] = 12;
        $projectData['id'] = $project->id;

        $this->actingAs($admin)->put(route('project.update', $projectData))
            ->assertStatus(422)
            ->assertExactJson([
                "message" => "Validation Exception",
                "errors" => [
                    "name" => [
                        "The name field must be between 3 and 20 characters."
                    ],
                    "description" => [
                        "The description field must not be greater than 255 characters."
                    ],
                    "goals" => [
                        "The goals field must not be greater than 150 characters."
                    ],
                    "status" => [
                        "The selected status is invalid."
                    ],
                    // "user_id" => [
                    //     "The user id field must be a number."
                    // ],
                ],
            ]);

        $projectData = Project::factory()->make([
            'name' => substr(fake()->text(), 1, 2),
            'user_id' => 99999999,
        ])->toArray();
        $projectData['id'] = $project->id;

        $this->actingAs($admin)->put(route('project.update', $projectData))
            ->assertStatus(422)
            ->assertExactJson([
                "message" => "Validation Exception",
                "errors" => [
                    "name" => [
                        "The name field must be between 3 and 20 characters."
                    ],
                    "user_id" => [
                        "The selected user id is invalid."
                    ],
                ],
            ]);
    }

    public function test_delete_admin_successfully(): void
    {
        $admin = User::factory()->create([ 'role' => Role::Admin->value ]);
        $project = Project::factory()->create();

        $this->actingAs($admin)->delete(route('project.destroy', ['id' => $project->id]))
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Project successfully removed.',
            ]);
    }

    public function test_delete_user_fail(): void
    {
        $user = User::factory()->create([ 'role' => Role::User->value ]);
        $project = Project::factory()->create();

        $this->actingAs($user)->delete(route('project.destroy', ['id' => $project->id]))
            ->assertStatus(403)
            ->assertJsonFragment([
                'message' => 'You do not have permission to access this resource.',
            ]);
    }
}
