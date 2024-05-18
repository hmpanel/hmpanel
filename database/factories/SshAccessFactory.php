<?php

namespace Database\Factories;

use App\Models\SshAccess;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SshAccessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SshAccess::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->text(255),
            'password' => $this->faker->password(),
            'web_app_id' => \App\Models\WebApp::factory(),
        ];
    }
}
