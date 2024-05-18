<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SshAccess;

use App\Models\WebApp;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SshAccessTest extends TestCase
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
    public function it_gets_ssh_accesses_list(): void
    {
        $sshAccesses = SshAccess::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.ssh-accesses.index'));

        $response->assertOk()->assertSee($sshAccesses[0]->username);
    }

    /**
     * @test
     */
    public function it_stores_the_ssh_access(): void
    {
        $data = SshAccess::factory()
            ->make()
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->postJson(route('api.ssh-accesses.store'), $data);

        unset($data['password']);

        $this->assertDatabaseHas('ssh_accesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_ssh_access(): void
    {
        $sshAccess = SshAccess::factory()->create();

        $webApp = WebApp::factory()->create();

        $data = [
            'username' => $this->faker->text(255),
            'web_app_id' => $webApp->id,
        ];

        $data['password'] = \Str::random('8');

        $response = $this->putJson(
            route('api.ssh-accesses.update', $sshAccess),
            $data
        );

        unset($data['password']);

        $data['id'] = $sshAccess->id;

        $this->assertDatabaseHas('ssh_accesses', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_ssh_access(): void
    {
        $sshAccess = SshAccess::factory()->create();

        $response = $this->deleteJson(
            route('api.ssh-accesses.destroy', $sshAccess)
        );

        $this->assertModelMissing($sshAccess);

        $response->assertNoContent();
    }
}
