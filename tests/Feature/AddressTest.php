<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testCreateAddress()
    {
        $customer = Factory::factoryForModel(\App\Models\Customer::class)->create();
        $addressData = [
            'customer_id' => $customer->id,
            'address' => $this->faker->streetAddress,
            'district' => $this->faker->city,
            'city' => $this->faker->city,
            'province' => $this->faker->state,
            'postal_code' => $this->faker->postcode,
        ];

        $response = $this->post('/addresses', $addressData);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Address created successfully']);

        $this->assertDatabaseHas('addresses', $addressData);
    }

    public function testUpdateAddress()
    {
        $customer = Factory::factoryForModel(\App\Models\Customer::class)->create();
        $address = Factory::factoryForModel(\App\Models\Address::class)->create();
        
        $updatedAddressData = [
            'customer_id' => $customer->id,
            'address' => $this->faker->streetAddress,
            'district' => $this->faker->city,
            'city' => $this->faker->city,
            'province' => $this->faker->state,
            'postal_code' => $this->faker->postcode,
        ];

        $response = $this->patch('/addresses/update/' . $address->id, $updatedAddressData);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Address updated successfully']);

        $this->assertDatabaseHas('addresses', $updatedAddressData);
    }

    public function testDeleteAddress()
    {
        $address = Factory::factoryForModel(\App\Models\Address::class)->create();

        $response = $this->delete('/addresses/delete/' . $address->id);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Address deleted']);

        $this->assertDatabaseMissing('addresses', ['id' => $address->id]);
    }
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
