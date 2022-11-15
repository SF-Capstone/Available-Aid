<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class getMapViewTest extends TestCase
{
    /**
     * Testing mapView page for successful response (valid input)
     *      
     * @return void
     */
  /** @test */
  public function get_map_view_test()
  {
    //   $response = $this->get(route('mapView', "shelterName"=>"do-good-multnomah-downtown-shelter"))
    //   ->assertOk();

    $response = $this->get(route('mapView', 'do-good-multnomah-downtown-shelter?shelterRow=4'))
      ->assertOk();

      
      $response->assertStatus(200);

 
    }
}
