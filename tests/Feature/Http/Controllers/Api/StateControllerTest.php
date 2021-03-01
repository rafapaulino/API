<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Country;
use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\StateController
 */
class StateControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $states = State::factory()->count(3)->create();

        $response = $this->get(route('state.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\StateController::class,
            'store',
            \App\Http\Requests\Api\StateStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $country = Country::factory()->create();
        $title = $this->faker->sentence(4);

        $response = $this->post(route('state.store'), [
            'country_id' => $country->id,
            'title' => $title,
        ]);

        $states = State::query()
            ->where('country_id', $country->id)
            ->where('title', $title)
            ->get();
        $this->assertCount(1, $states);
        $state = $states->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $state = State::factory()->create();

        $response = $this->get(route('state.show', $state));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Api\StateController::class,
            'update',
            \App\Http\Requests\Api\StateUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $state = State::factory()->create();
        $country = Country::factory()->create();
        $title = $this->faker->sentence(4);

        $response = $this->put(route('state.update', $state), [
            'country_id' => $country->id,
            'title' => $title,
        ]);

        $state->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($country->id, $state->country_id);
        $this->assertEquals($title, $state->title);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $state = State::factory()->create();

        $response = $this->delete(route('state.destroy', $state));

        $response->assertNoContent();

        $this->assertSoftDeleted($state);
    }
}
