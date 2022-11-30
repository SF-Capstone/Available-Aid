<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class getFilterInfoInvalidTest extends TestCase
{
    /**
    *  Testing get filter info page for unsuccessful response (invalid input)
     *
     * @return void
     */
    /** @test */
public function get_filter_info_invalid()
{
    $response = $this->json('GET', '/invalidInput');
    $response->assertStatus(404);
  
}
}
