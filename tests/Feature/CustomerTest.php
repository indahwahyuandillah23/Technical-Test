<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate', ['--database' => 'testing']);

        Artisan::call('db:seed', ['--class' => 'CustomerSeeder', '--database' => 'testing']);
    }

    public function testIndex()
    {
        $customer = Factory::factoryForModel(\App\Models\Customer::class)->create();

        $response = $this->get('/index');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'name',
                        'gender',
                        'phone_number',
                        'image',
                        'email',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'pagination' => [
                    'current_page',
                    'total',
                    'per_page',
                ],
            ]);
    }

    public function testIndexWithSearch()
    {
        $customer = Factory::factoryForModel(\App\Models\Customer::class)->create();

        $search = 'John';
        $response = $this->get('/index?search' . $search);
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'name',
                        'gender',
                        'phone_number',
                        'image',
                        'email',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'pagination' => [
                    'current_page',
                    'total',
                    'per_page',
                ],
            ]);
    }

    public function testIndexWithFilterGender()
    {
        $customer = Factory::factoryForModel(\App\Models\Customer::class)->create();

        $filterGender = 'M';
        $response = $this->get('/index?search' . $filterGender);
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'name',
                        'gender',
                        'phone_number',
                        'image',
                        'email',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'pagination' => [
                    'current_page',
                    'total',
                    'per_page',
                ],
            ]);
    }

    public function testDetail()
    {
        $customer = Factory::factoryForModel(\App\Models\Customer::class)->create();

        $response = $this->get('/detail/' . $customer->id);
        
        $response->assertStatus(200)
        ->assertJsonStructure([
            'id',
            'title',
            'name',
            'gender',
            'phone_number',
            'image',
            'email',
            'created_at',
            'updated_at',
            'addresses' => [
                '*' => [
                    'id',
                    'customer_id',
                    'address',
                    'district',
                    'city',
                    'province',
                    'postal_code',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    public function testUpdate()
    {
        $updatedData = [
            'title' => 'Mrs',
            'name' => 'Jane Smith',
            'gender' => 'F',
            'phone_number' => '9876543210',
            'image' => 'https://example.com/new-image.jpg',
            'email' => 'janesmith@example.com',
        ];

        $customer = Factory::factoryForModel(\App\Models\Customer::class)->create();

        $response = $this->patch('/update/' . $customer->id, $updatedData);
        
        $response->assertStatus(201)
        ->assertJson(['message' => 'Customer updated successfully']);

        $this->assertDatabaseHas('customers', $updatedData);
    }

    public function testDelete()
    {
        $customer = Factory::factoryForModel(\App\Models\Customer::class)->create();

        $response = $this->delete('/delete/' . $customer->id);
        
        $response->assertStatus(200)
        ->assertJson(['message' => 'Customer deleted']);

        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
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
