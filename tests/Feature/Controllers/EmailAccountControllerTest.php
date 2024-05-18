<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\EmailAccount;

use App\Models\WebApp;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailAccountControllerTest extends TestCase
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
    public function it_displays_index_view_with_email_accounts(): void
    {
        $emailAccounts = EmailAccount::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('email-accounts.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.email_accounts.index')
            ->assertViewHas('emailAccounts');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_email_account(): void
    {
        $response = $this->get(route('email-accounts.create'));

        $response->assertOk()->assertViewIs('app.email_accounts.create');
    }

    /**
     * @test
     */
    public function it_stores_the_email_account(): void
    {
        $data = EmailAccount::factory()
            ->make()
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->post(route('email-accounts.store'), $data);

        unset($data['password']);

        $this->assertDatabaseHas('email_accounts', $data);

        $emailAccount = EmailAccount::latest('id')->first();

        $response->assertRedirect(route('email-accounts.edit', $emailAccount));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_email_account(): void
    {
        $emailAccount = EmailAccount::factory()->create();

        $response = $this->get(route('email-accounts.show', $emailAccount));

        $response
            ->assertOk()
            ->assertViewIs('app.email_accounts.show')
            ->assertViewHas('emailAccount');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_email_account(): void
    {
        $emailAccount = EmailAccount::factory()->create();

        $response = $this->get(route('email-accounts.edit', $emailAccount));

        $response
            ->assertOk()
            ->assertViewIs('app.email_accounts.edit')
            ->assertViewHas('emailAccount');
    }

    /**
     * @test
     */
    public function it_updates_the_email_account(): void
    {
        $emailAccount = EmailAccount::factory()->create();

        $webApp = WebApp::factory()->create();

        $data = [
            'email' => $this->faker->email(),
            'web_app_id' => $webApp->id,
        ];

        $data['password'] = \Str::random('8');

        $response = $this->put(
            route('email-accounts.update', $emailAccount),
            $data
        );

        unset($data['password']);

        $data['id'] = $emailAccount->id;

        $this->assertDatabaseHas('email_accounts', $data);

        $response->assertRedirect(route('email-accounts.edit', $emailAccount));
    }

    /**
     * @test
     */
    public function it_deletes_the_email_account(): void
    {
        $emailAccount = EmailAccount::factory()->create();

        $response = $this->delete(
            route('email-accounts.destroy', $emailAccount)
        );

        $response->assertRedirect(route('email-accounts.index'));

        $this->assertModelMissing($emailAccount);
    }
}
