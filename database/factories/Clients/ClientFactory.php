<?php

namespace Database\Factories\Clients;

use App\Clients\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClientFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Client::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		return [
			'name' => $this->faker->name(),
			'api_key' => Str::random(40),
			'sent_notifications_count' => rand(0, 100),
			'notifications_retention_days' => rand(1, 365),
		];
	}
}
