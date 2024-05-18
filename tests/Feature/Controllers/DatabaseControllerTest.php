<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Database;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_databases(): void
    {
        $databases = Database::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('databases.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.databases.index')
            ->assertViewHas('databases');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_database(): void
    {
        $response = $this->get(route('databases.create'));

        $response->assertOk()->assertViewIs('app.databases.create');
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

        $response = $this->post(route('databases.store'), $data);

        unset($data['password']);

        $this->assertDatabaseHas('databases', $data);

        $database = Database::latest('id')->first();

        $response->assertRedirect(route('databases.edit', $database));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_database(): void
    {
        $database = Database::factory()->create();

        $response = $this->get(route('databases.show', $database));

        $response
            ->assertOk()
            ->assertViewIs('app.databases.show')
            ->assertViewHas('database');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_database(): void
    {
        $database = Database::factory()->create();

        $response = $this->get(route('databases.edit', $database));

        $response
            ->assertOk()
            ->assertViewIs('app.databases.edit')
            ->assertViewHas('database');
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

        $response = $this->put(route('databases.update', $database), $data);

        unset($data['password']);

        $data['id'] = $database->id;

        $this->assertDatabaseHas('databases', $data);

        $response->assertRedirect(route('databases.edit', $database));
    }

    /**
     * @test
     */
    public function it_deletes_the_database(): void
    {
        $database = Database::factory()->create();

        $response = $this->delete(route('databases.destroy', $database));

        $response->assertRedirect(route('databases.index'));

        $this->assertModelMissing($database);
    }
}
