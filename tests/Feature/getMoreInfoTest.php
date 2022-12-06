<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class getMoreInfoTest extends TestCase
{
    /**
     *  Testing get more info page for successful response (valid input)
     *
     * @return void
     */
  /** @test */
  public function get_more_info_test()
  {

       $response = $this->get(route('results', ['shelterName'=>'do-good-multnomah-downtown-shelter']))
      ->assertOk();
   
      $response->assertStatus(200);

  }
}
