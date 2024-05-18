<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\EmailAccount;

use App\Models\WebApp;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailAccountTest extends TestCase
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
    public function it_gets_email_accounts_list(): void
    {
        $emailAccounts = EmailAccount::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.email-accounts.index'));

        $response->assertOk()->assertSee($emailAccounts[0]->email);
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

        $response = $this->postJson(route('api.email-accounts.store'), $data);

        unset($data['password']);

        $this->assertDatabaseHas('email_accounts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.email-accounts.update', $emailAccount),
            $data
        );

        unset($data['password']);

        $data['id'] = $emailAccount->id;

        $this->assertDatabaseHas('email_accounts', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_email_account(): void
    {
        $emailAccount = EmailAccount::factory()->create();

        $response = $this->deleteJson(
            route('api.email-accounts.destroy', $emailAccount)
        );

        $this->assertModelMissing($emailAccount);

        $response->assertNoContent();
    }
}
