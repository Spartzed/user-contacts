<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\pt_BR\Person;
use Faker\Provider\pt_BR\Address;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        $this->faker->addProvider(new Person($this->faker));
        $this->faker->addProvider(new Address($this->faker));

        return [
            'name' => $this->faker->name,
            'cpf' => $this->faker->cpf(false),
            'phone' => $this->faker->phoneNumber,
            'logradouro' => $this->faker->streetName,
            'numero' => $this->faker->buildingNumber,
            'cep' => $this->faker->postcode,
            'bairro' => $this->faker->citySuffix,
            'cidade' => $this->faker->city,
            'uf' => $this->faker->stateAbbr,
            'complemento' => $this->faker->secondaryAddress,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];
    }
}
