<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class requiredInputTest extends DuskTestCase
{
    /**
     * Test to validate required buttons (Male/Female/Female).
     * If the required field is not selected then result page should not show
     * @test
     * @return void
     */
    public function test_to_validate_without_required_input()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Portland Aid Guide')
                    ->press('Search')
                  
                    ->whenAvailable('.modal', function($modal){
                        $modal->assertSee('Search')
                        ->assertSee('Gender')
                        ->press('Continue')
                        ->assertPathIS('/')
                        ->assertPathIsNot('/results');
                    });
        });
    }
}