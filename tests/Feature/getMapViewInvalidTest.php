<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class getMapViewInvalid extends TestCase
{
    /**
    *  Testing get  map view page for unsuccessful response (invalid input)
     *
     * @return void
     */
      /** @test */
    public function get_map_view_invalid()
    {
        $response = $this->json('GET', '/invalidInput', ['shelterName'=>'do-good-multnomah-downtown-shelter']);
        $response->assertStatus(404);
    }
}
