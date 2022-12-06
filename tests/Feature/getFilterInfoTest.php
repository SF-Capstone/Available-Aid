<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class getFilterInfoTest extends TestCase
{
    /**
     * Testing filter page for successful response (valid input)
     *
     * @return void
     */
    /** @test */
    public function get_filter_info_valid_input()
    {
        $response = $this->get(Route('getFilterInfo'))
        ->assertOk();
      
        $response->assertStatus(200);

    }
}
