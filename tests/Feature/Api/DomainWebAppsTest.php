<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Domain;
use App\Models\WebApp;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DomainWebAppsTest extends TestCase
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
    public function it_gets_domain_web_apps(): void
    {
        $domain = Domain::factory()->create();
        $webApps = WebApp::factory()
            ->count(2)
            ->create([
                'domain_id' => $domain->id,
            ]);

        $response = $this->getJson(
            route('api.domains.web-apps.index', $domain)
        );

        $response->assertOk()->assertSee($webApps[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_domain_web_apps(): void
    {
        $domain = Domain::factory()->create();
        $data = WebApp::factory()
            ->make([
                'domain_id' => $domain->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.domains.web-apps.store', $domain),
            $data
        );

        $this->assertDatabaseHas('web_apps', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $webApp = WebApp::latest('id')->first();

        $this->assertEquals($domain->id, $webApp->domain_id);
    }
}
