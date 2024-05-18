<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Domain;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DomainControllerTest extends TestCase
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
    public function it_displays_index_view_with_domains(): void
    {
        $domains = Domain::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('domains.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.domains.index')
            ->assertViewHas('domains');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_domain(): void
    {
        $response = $this->get(route('domains.create'));

        $response->assertOk()->assertViewIs('app.domains.create');
    }

    /**
     * @test
     */
    public function it_stores_the_domain(): void
    {
        $data = Domain::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('domains.store'), $data);

        $this->assertDatabaseHas('domains', $data);

        $domain = Domain::latest('id')->first();

        $response->assertRedirect(route('domains.edit', $domain));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_domain(): void
    {
        $domain = Domain::factory()->create();

        $response = $this->get(route('domains.show', $domain));

        $response
            ->assertOk()
            ->assertViewIs('app.domains.show')
            ->assertViewHas('domain');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_domain(): void
    {
        $domain = Domain::factory()->create();

        $response = $this->get(route('domains.edit', $domain));

        $response
            ->assertOk()
            ->assertViewIs('app.domains.edit')
            ->assertViewHas('domain');
    }

    /**
     * @test
     */
    public function it_updates_the_domain(): void
    {
        $domain = Domain::factory()->create();

        $data = [
            'name' => $this->faker->name(),
        ];

        $response = $this->put(route('domains.update', $domain), $data);

        $data['id'] = $domain->id;

        $this->assertDatabaseHas('domains', $data);

        $response->assertRedirect(route('domains.edit', $domain));
    }

    /**
     * @test
     */
    public function it_deletes_the_domain(): void
    {
        $domain = Domain::factory()->create();

        $response = $this->delete(route('domains.destroy', $domain));

        $response->assertRedirect(route('domains.index'));

        $this->assertModelMissing($domain);
    }
}
