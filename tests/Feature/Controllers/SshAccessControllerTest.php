<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\SshAccess;

use App\Models\WebApp;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SshAccessControllerTest extends TestCase
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
    public function it_displays_index_view_with_ssh_accesses(): void
    {
        $sshAccesses = SshAccess::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('ssh-accesses.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.ssh_accesses.index')
            ->assertViewHas('sshAccesses');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_ssh_access(): void
    {
        $response = $this->get(route('ssh-accesses.create'));

        $response->assertOk()->assertViewIs('app.ssh_accesses.create');
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

        $response = $this->post(route('ssh-accesses.store'), $data);

        unset($data['password']);

        $this->assertDatabaseHas('ssh_accesses', $data);

        $sshAccess = SshAccess::latest('id')->first();

        $response->assertRedirect(route('ssh-accesses.edit', $sshAccess));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_ssh_access(): void
    {
        $sshAccess = SshAccess::factory()->create();

        $response = $this->get(route('ssh-accesses.show', $sshAccess));

        $response
            ->assertOk()
            ->assertViewIs('app.ssh_accesses.show')
            ->assertViewHas('sshAccess');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_ssh_access(): void
    {
        $sshAccess = SshAccess::factory()->create();

        $response = $this->get(route('ssh-accesses.edit', $sshAccess));

        $response
            ->assertOk()
            ->assertViewIs('app.ssh_accesses.edit')
            ->assertViewHas('sshAccess');
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

        $response = $this->put(route('ssh-accesses.update', $sshAccess), $data);

        unset($data['password']);

        $data['id'] = $sshAccess->id;

        $this->assertDatabaseHas('ssh_accesses', $data);

        $response->assertRedirect(route('ssh-accesses.edit', $sshAccess));
    }

    /**
     * @test
     */
    public function it_deletes_the_ssh_access(): void
    {
        $sshAccess = SshAccess::factory()->create();

        $response = $this->delete(route('ssh-accesses.destroy', $sshAccess));

        $response->assertRedirect(route('ssh-accesses.index'));

        $this->assertModelMissing($sshAccess);
    }
}
