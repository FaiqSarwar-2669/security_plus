<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Testing\Fakes\Fake;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\registeration>
 */
class registerationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // return [
        //     'bussiness_fname' => fake()->firstName(),
        //     'bussiness_lname' => fake()->lastName(),
        //     'bussiness_owner' => fake()->name(),
        //     'area_code' => fake()->areaCode(),
        //     'phone_number' => fake()->phoneNumber(),
        //     'street_address' => fake()->streetAddress(),
        //     'city_name' => fake()->city(),
        //     'province' => fake()->state(),
        //     'bussiness_type' => 'Service Taker',
        //     'email' => fake()->safeEmail(),
        //     'password' => Hash::make('default_password'),
        //     'active' => false,
        // ];
        return [
            'bussiness_fname' => 'Sequrity',
            'bussiness_lname' => 'Plus',
            'bussiness_owner' => 'Faiq Sarwar',
            'area_code' => '',
            'phone_number' => '',
            'street_address' => '',
            'city_name' => '',
            'province' => '',
            'bussiness_type' => 'Admin',
            'profile' => '',
            'email' => 'code.faiq786@gmail.com',
            'password' => Hash::make('Faiq@786'),
            'active' => true,
        ];
    }
}
