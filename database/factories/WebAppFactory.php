<?php

namespace Database\Factories;

use App\Models\WebApp;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class WebAppFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WebApp::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'path' => $this->faker->text(255),
            'domain_id' => \App\Models\Domain::factory(),
        ];
    }
}
