<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Domain;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DomainTest extends TestCase
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
    public function it_gets_domains_list(): void
    {
        $domains = Domain::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.domains.index'));

        $response->assertOk()->assertSee($domains[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_domain(): void
    {
        $data = Domain::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.domains.store'), $data);

        $this->assertDatabaseHas('domains', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(route('api.domains.update', $domain), $data);

        $data['id'] = $domain->id;

        $this->assertDatabaseHas('domains', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_domain(): void
    {
        $domain = Domain::factory()->create();

        $response = $this->deleteJson(route('api.domains.destroy', $domain));

        $this->assertModelMissing($domain);

        $response->assertNoContent();
    }
}
