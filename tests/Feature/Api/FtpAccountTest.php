<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FtpAccount;

use App\Models\WebApp;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FtpAccountTest extends TestCase
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
    public function it_gets_ftp_accounts_list(): void
    {
        $ftpAccounts = FtpAccount::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.ftp-accounts.index'));

        $response->assertOk()->assertSee($ftpAccounts[0]->username);
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

        $response = $this->postJson(route('api.ftp-accounts.store'), $data);

        unset($data['password']);

        $this->assertDatabaseHas('ftp_accounts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.ftp-accounts.update', $ftpAccount),
            $data
        );

        unset($data['password']);

        $data['id'] = $ftpAccount->id;

        $this->assertDatabaseHas('ftp_accounts', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_ftp_account(): void
    {
        $ftpAccount = FtpAccount::factory()->create();

        $response = $this->deleteJson(
            route('api.ftp-accounts.destroy', $ftpAccount)
        );

        $this->assertModelMissing($ftpAccount);

        $response->assertNoContent();
    }
}
