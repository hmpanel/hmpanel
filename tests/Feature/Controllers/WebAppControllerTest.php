<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\WebApp;

use App\Models\Domain;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAppControllerTest extends TestCase
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
    public function it_displays_index_view_with_web_apps(): void
    {
        $webApps = WebApp::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('web-apps.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.web_apps.index')
            ->assertViewHas('webApps');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_web_app(): void
    {
        $response = $this->get(route('web-apps.create'));

        $response->assertOk()->assertViewIs('app.web_apps.create');
    }

    /**
     * @test
     */
    public function it_stores_the_web_app(): void
    {
        $data = WebApp::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('web-apps.store'), $data);

        $this->assertDatabaseHas('web_apps', $data);

        $webApp = WebApp::latest('id')->first();

        $response->assertRedirect(route('web-apps.edit', $webApp));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_web_app(): void
    {
        $webApp = WebApp::factory()->create();

        $response = $this->get(route('web-apps.show', $webApp));

        $response
            ->assertOk()
            ->assertViewIs('app.web_apps.show')
            ->assertViewHas('webApp');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_web_app(): void
    {
        $webApp = WebApp::factory()->create();

        $response = $this->get(route('web-apps.edit', $webApp));

        $response
            ->assertOk()
            ->assertViewIs('app.web_apps.edit')
            ->assertViewHas('webApp');
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

        $response = $this->put(route('web-apps.update', $webApp), $data);

        $data['id'] = $webApp->id;

        $this->assertDatabaseHas('web_apps', $data);

        $response->assertRedirect(route('web-apps.edit', $webApp));
    }

    /**
     * @test
     */
    public function it_deletes_the_web_app(): void
    {
        $webApp = WebApp::factory()->create();

        $response = $this->delete(route('web-apps.destroy', $webApp));

        $response->assertRedirect(route('web-apps.index'));

        $this->assertModelMissing($webApp);
    }
}
