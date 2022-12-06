<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CloseButtonTest extends DuskTestCase
{
    /**
     * Test to validate close button by moving back to main page
     * @test
     * 
     * 
     * @return void
     */
    public function test_to_validate_close_button()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Portland Aid Guide')
                    ->press('Search')
                  
                    ->whenAvailable('.modal', function($modal){
                        $modal->assertSee('Search')
                        ->assertSee('Pet friendly')
                        ->assertSee('Sober living')
                        ->press('Close')
                        ->assertPathIS('/')
                       ->assertPathIsNot('/results');
                    });
        });
    }
}