<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\WebApp;
use App\Models\SshAccess;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAppSshAccessesTest extends TestCase
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
    public function it_gets_web_app_ssh_accesses(): void
    {
        $webApp = WebApp::factory()->create();
        $sshAccesses = SshAccess::factory()
            ->count(2)
            ->create([
                'web_app_id' => $webApp->id,
            ]);

        $response = $this->getJson(
            route('api.web-apps.ssh-accesses.index', $webApp)
        );

        $response->assertOk()->assertSee($sshAccesses[0]->username);
    }

    /**
     * @test
     */
    public function it_stores_the_web_app_ssh_accesses(): void
    {
        $webApp = WebApp::factory()->create();
        $data = SshAccess::factory()
            ->make([
                'web_app_id' => $webApp->id,
            ])
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->postJson(
            route('api.web-apps.ssh-accesses.store', $webApp),
            $data
        );

        unset($data['password']);

        $this->assertDatabaseHas('ssh_accesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $sshAccess = SshAccess::latest('id')->first();

        $this->assertEquals($webApp->id, $sshAccess->web_app_id);
    }
}
