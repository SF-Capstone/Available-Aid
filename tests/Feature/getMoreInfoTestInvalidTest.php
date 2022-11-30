<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class getMoreInfoTestInvalid extends TestCase
{
  /**
     *  Testing get more info page for unsuccessful response (invalid input)
     *
     * @return void
     */
  /** @test */
     public function get_more_info_invalid()
     {
         $response = $this->json('GET', '/invalidInput', ['shelterName'=>'do-good-multnomah-downtown-shelter']);
         $response->assertStatus(404);
       
     }
}
