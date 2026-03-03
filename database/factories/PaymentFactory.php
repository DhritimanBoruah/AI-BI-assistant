<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id'    => \App\Models\Member::inRandomOrder()->first()->id ?? 1,
            'amount'       => $this->faker->numberBetween(500, 5000),
            'payment_date' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'created_at'   => now(),
            'updated_at'   => now(),
        ];
    }
}
