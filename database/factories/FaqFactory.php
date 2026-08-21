<?php

namespace Database\Factories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, string>
     */
    public function definition(): array
    {
        return [
            'question' => $this->faker->sentence(),
            'answer' => $this->faker->paragraph(),
        ];
    }

     /**
     * Define the model's custom placeholder state.
     *
     * @return array<string, string>
     */
    public function placeholder(): static
    {
        // this is how to define a (simple) custom state for factories in Laravel
        return $this->state([
            'question' => 'Placeholder Question?',
            'answer' => 'Placeholder Answer.'
        ]);
    }
}
