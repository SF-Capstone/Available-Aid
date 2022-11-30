<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class getShelterInfoTest extends TestCase
{
    /**
     * Testing results page for successful response (valid input) .
     *
     * @return void
     */
  /** @test */
  public function get_shelter_info_test()
  {
      $response = $this->get(Route('results'))
      ->assertOk();
      $response->assertStatus(200);

  }
}