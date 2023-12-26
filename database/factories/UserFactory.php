<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        static $password;

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' =>  $password ?: $password = bcrypt('123'),
            'group_role' =>  fake()->randomElement(['admin', 'editor', 'reviewer']),
            'remember_token' => Str::random(100),
            'verify_email' => fake()->randomElement([null, fake()->unique()->safeEmail()]),
            'is_active' => fake()->randomElement([0, 1]),
            'is_delete' =>  fake()->randomElement([0, 1]),
            'last_login_at' => fake()->dateTimeThisYear(),
            'last_login_ip' => fake()->ipv4(),
            'created_at' => fake()->dateTimeThisDecade(),
            'updated_at' => fake()->dateTimeThisDecade(),
        ];
    }
}
