<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'title' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['pengaduan', 'aspirasi']),
            'content' => $this->faker->paragraphs(3, true),
            'image' => null, // Will be set when needed
            'date_of_incident' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'location_address' => $this->faker->address(),
            'latitude' => $this->faker->latitude(-10, 10), // Indonesia range
            'longitude' => $this->faker->longitude(95, 141), // Indonesia range
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }

    /**
     * Indicate that the report is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Indicate that the report is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
        ]);
    }

    /**
     * Indicate that the report is rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
        ]);
    }

    /**
     * Indicate that the report is a pengaduan.
     */
    public function pengaduan(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'pengaduan',
        ]);
    }

    /**
     * Indicate that the report is an aspirasi.
     */
    public function aspirasi(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'aspirasi',
        ]);
    }
}
