<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\City;
use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\CityController
 */
class CityControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $cities = City::factory()->count(3)->create();

        $response = $this->get(route('city.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\CityController::class,
            'store',
            \App\Http\Requests\Api\CityStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $state = State::factory()->create();
        $title = $this->faker->sentence(4);

        $response = $this->post(route('city.store'), [
            'state_id' => $state->id,
            'title' => $title,
        ]);

        $cities = City::query()
            ->where('state_id', $state->id)
            ->where('title', $title)
            ->get();
        $this->assertCount(1, $cities);
        $city = $cities->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $city = City::factory()->create();

        $response = $this->get(route('city.show', $city));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\CityController::class,
            'update',
            \App\Http\Requests\Api\CityUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $city = City::factory()->create();
        $state = State::factory()->create();
        $title = $this->faker->sentence(4);

        $response = $this->put(route('city.update', $city), [
            'state_id' => $state->id,
            'title' => $title,
        ]);

        $city->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($state->id, $city->state_id);
        $this->assertEquals($title, $city->title);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $city = City::factory()->create();

        $response = $this->delete(route('city.destroy', $city));

        $response->assertNoContent();

        $this->assertSoftDeleted($city);
    }
}
