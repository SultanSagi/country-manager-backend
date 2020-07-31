<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageCountriesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Fetch all countries
     *
     * @return void
     */
    public function testIndex()
    {
        $country = factory('App\Country')->create();

        $this->get('api/countries')
            ->assertSee($country->country);
    }

    /**
     * Get one country detail
     *
     * @return void
     */
    public function testShow()
    {
        $country = factory('App\Country')->create();

        $this->get('api/countries/'.$country->id)
            ->assertSee($country->country);
    }

    /**
     * Create new country
     *
     * @return void
     */
    public function testCreate()
    {
        $attributes = [
            'country' => 'New country',
            'capital' => 'Capital of the country'
        ];

        $response = $this->postJson('api/countries', $attributes);

        $response
            ->assertCreated()
            ->assertJsonStructure([
                'country' => [
                    'id',
                    'country',
                    'capital'
                ],
            ]);
    }

    /**
     * Update a country
     *
     * @return void
     */
    public function testUpdate()
    {
        $country = factory('App\Country')->create();

        $attributes = [
            'country' => 'Country updated',
            'capital' => 'Capital updated'
        ];

        $response = $this->patchJson('api/countries/'.$country->id, $attributes);

        $response
            ->assertOk();

        $this->assertEquals($attributes['country'], $country->fresh()->country);
        $this->assertEquals($attributes['capital'], $country->fresh()->capital);
    }

    /**
     * Delete a country
     *
     * @return void
     */
    public function testDelete()
    {
        $country = factory('App\Country')->create();

        $response = $this->deleteJson('api/countries/'.$country->id);

        $response
            ->assertNoContent();

        $this->assertDatabaseMissing('countries', ['id' => $country->id]);
    }
}
