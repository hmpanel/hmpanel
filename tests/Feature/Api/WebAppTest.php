<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\WebApp;

use App\Models\Domain;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAppTest extends TestCase
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
    public function it_gets_web_apps_list(): void
    {
        $webApps = WebApp::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.web-apps.index'));

        $response->assertOk()->assertSee($webApps[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_web_app(): void
    {
        $data = WebApp::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.web-apps.store'), $data);

        $this->assertDatabaseHas('web_apps', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_web_app(): void
    {
        $webApp = WebApp::factory()->create();

        $domain = Domain::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'path' => $this->faker->text(255),
            'domain_id' => $domain->id,
        ];

        $response = $this->putJson(
            route('api.web-apps.update', $webApp),
            $data
        );

        $data['id'] = $webApp->id;

        $this->assertDatabaseHas('web_apps', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_web_app(): void
    {
        $webApp = WebApp::factory()->create();

        $response = $this->deleteJson(route('api.web-apps.destroy', $webApp));

        $this->assertModelMissing($webApp);

        $response->assertNoContent();
    }
}
