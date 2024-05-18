<?php

namespace Database\Factories;

use App\Models\TechVersion;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TechVersionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TechVersion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'version' => $this->faker->text(255),
            'technology_id' => \App\Models\Technology::factory(),
        ];
    }
}
