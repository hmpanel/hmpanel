<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\WebApp;
use App\Models\EmailAccount;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebAppEmailAccountsTest extends TestCase
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
    public function it_gets_web_app_email_accounts(): void
    {
        $webApp = WebApp::factory()->create();
        $emailAccounts = EmailAccount::factory()
            ->count(2)
            ->create([
                'web_app_id' => $webApp->id,
            ]);

        $response = $this->getJson(
            route('api.web-apps.email-accounts.index', $webApp)
        );

        $response->assertOk()->assertSee($emailAccounts[0]->email);
    }

    /**
     * @test
     */
    public function it_stores_the_web_app_email_accounts(): void
    {
        $webApp = WebApp::factory()->create();
        $data = EmailAccount::factory()
            ->make([
                'web_app_id' => $webApp->id,
            ])
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->postJson(
            route('api.web-apps.email-accounts.store', $webApp),
            $data
        );

        unset($data['password']);

        $this->assertDatabaseHas('email_accounts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $emailAccount = EmailAccount::latest('id')->first();

        $this->assertEquals($webApp->id, $emailAccount->web_app_id);
    }
}
