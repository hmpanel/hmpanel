<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\FtpAccount;

use App\Models\WebApp;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FtpAccountControllerTest extends TestCase
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
    public function it_displays_index_view_with_ftp_accounts(): void
    {
        $ftpAccounts = FtpAccount::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('ftp-accounts.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.ftp_accounts.index')
            ->assertViewHas('ftpAccounts');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_ftp_account(): void
    {
        $response = $this->get(route('ftp-accounts.create'));

        $response->assertOk()->assertViewIs('app.ftp_accounts.create');
    }

    /**
     * @test
     */
    public function it_stores_the_ftp_account(): void
    {
        $data = FtpAccount::factory()
            ->make()
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->post(route('ftp-accounts.store'), $data);

        unset($data['password']);

        $this->assertDatabaseHas('ftp_accounts', $data);

        $ftpAccount = FtpAccount::latest('id')->first();

        $response->assertRedirect(route('ftp-accounts.edit', $ftpAccount));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_ftp_account(): void
    {
        $ftpAccount = FtpAccount::factory()->create();

        $response = $this->get(route('ftp-accounts.show', $ftpAccount));

        $response
            ->assertOk()
            ->assertViewIs('app.ftp_accounts.show')
            ->assertViewHas('ftpAccount');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_ftp_account(): void
    {
        $ftpAccount = FtpAccount::factory()->create();

        $response = $this->get(route('ftp-accounts.edit', $ftpAccount));

        $response
            ->assertOk()
            ->assertViewIs('app.ftp_accounts.edit')
            ->assertViewHas('ftpAccount');
    }

    /**
     * @test
     */
    public function it_updates_the_ftp_account(): void
    {
        $ftpAccount = FtpAccount::factory()->create();

        $webApp = WebApp::factory()->create();

        $data = [
            'username' => $this->faker->text(255),
            'web_app_id' => $webApp->id,
        ];

        $data['password'] = \Str::random('8');

        $response = $this->put(
            route('ftp-accounts.update', $ftpAccount),
            $data
        );

        unset($data['password']);

        $data['id'] = $ftpAccount->id;

        $this->assertDatabaseHas('ftp_accounts', $data);

        $response->assertRedirect(route('ftp-accounts.edit', $ftpAccount));
    }

    /**
     * @test
     */
    public function it_deletes_the_ftp_account(): void
    {
        $ftpAccount = FtpAccount::factory()->create();

        $response = $this->delete(route('ftp-accounts.destroy', $ftpAccount));

        $response->assertRedirect(route('ftp-accounts.index'));

        $this->assertModelMissing($ftpAccount);
    }
}
