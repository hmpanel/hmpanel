<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\WebApp;
use App\Models\FtpAccount;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAppFtpAccountsTest extends TestCase
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
    public function it_gets_web_app_ftp_accounts(): void
    {
        $webApp = WebApp::factory()->create();
        $ftpAccounts = FtpAccount::factory()
            ->count(2)
            ->create([
                'web_app_id' => $webApp->id,
            ]);

        $response = $this->getJson(
            route('api.web-apps.ftp-accounts.index', $webApp)
        );

        $response->assertOk()->assertSee($ftpAccounts[0]->username);
    }

    /**
     * @test
     */
    public function it_stores_the_web_app_ftp_accounts(): void
    {
        $webApp = WebApp::factory()->create();
        $data = FtpAccount::factory()
            ->make([
                'web_app_id' => $webApp->id,
            ])
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->postJson(
            route('api.web-apps.ftp-accounts.store', $webApp),
            $data
        );

        unset($data['password']);

        $this->assertDatabaseHas('ftp_accounts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $ftpAccount = FtpAccount::latest('id')->first();

        $this->assertEquals($webApp->id, $ftpAccount->web_app_id);
    }
}
