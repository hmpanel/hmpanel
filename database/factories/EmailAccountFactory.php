<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\EmailAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmailAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->email(),
            'password' => $this->faker->password(),
            'web_app_id' => \App\Models\WebApp::factory(),
        ];
    }
}
