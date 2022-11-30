<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class getShelterinfoInvalidTest extends TestCase
{
    /**
    *  Testing get shelter info page for unsuccessful response (invalid input)
     *
     * @return void
     */
    /** @test */
    public function get_shelter_info_invalid()
    {
        $response = $this->json('GET', '/badPath');
        $response->assertStatus(404);
      
    }
}
