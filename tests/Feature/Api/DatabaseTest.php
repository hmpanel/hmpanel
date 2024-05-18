<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Database;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_databases_list(): void
    {
        $databases = Database::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.databases.index'));

        $response->assertOk()->assertSee($databases[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_database(): void
    {
        $data = Database::factory()
            ->make()
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->postJson(route('api.databases.store'), $data);

        unset($data['password']);

        $this->assertDatabaseHas('databases', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_database(): void
    {
        $database = Database::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'username' => $this->faker->text(255),
        ];

        $data['password'] = \Str::random('8');

        $response = $this->putJson(
            route('api.databases.update', $database),
            $data
        );

        unset($data['password']);

        $data['id'] = $database->id;

        $this->assertDatabaseHas('databases', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_database(): void
    {
        $database = Database::factory()->create();

        $response = $this->deleteJson(
            route('api.databases.destroy', $database)
        );

        $this->assertModelMissing($database);

        $response->assertNoContent();
    }
}
