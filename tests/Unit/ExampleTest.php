<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery\MockInterface;
use Illuminate\Testing\Fluent\AssertableJson;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_true_is_true()
    {
        $this->assertTrue(true);
    }
    
    public function test_getImage_route_passes()
    {
        $response = $this->get(route('getImage', ['imageName' => 'Blanchet House']));
        $response
            ->assertStatus(200);
    }

    public function test_getImage_route_fails()
    {
        $response = $this->get(route('getImage', ['imageName' => 'foo']));
        $response
            ->assertStatus(500);
    }

    public function test_getFilterInfo_route() {
        $response = $this->get(route('getFilterInfo'));
        $response
            ->assertViewIs('welcome')
            ->assertViewHasAll([
                'result'
            ]);
    }

    public function test_getShelterLocation_route()
    {
        $response = $this->get(route('map', ['shelterRow' => 1, 'shelterName' => 'blanchet-house']));
        $response
            ->assertViewIs('mapView')
            ->assertViewHasAll([
                'result'
            ]);
    }

    public function test_getShelterInfo_route()
    {
        $response = $this->get(route('results'));
        $response
            ->assertViewIs('results')
            ->assertViewHasAll([
                'shelterResultInfo',
                'lastFormInput'
            ]);
    }

    public function test_getMoreInfo_route()
    {
        $response = $this->get(route('info', ['shelterRow' => 1, 'shelterName' => 'blanchet-house']));
        $response
            ->assertViewIs('information')
            ->assertViewHasAll([
                'result'
            ]);
    }
}
