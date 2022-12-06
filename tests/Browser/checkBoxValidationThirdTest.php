<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class checkBoxValidationThirdTest extends DuskTestCase
{
   
    /**
    * @return string
    */
    public function url()
    {
        return '/results';
    }

  /**
     * Test to validate "ADA", "LGBTQA", and "Religious" checkboxes 
     * with "Male" gender selected. Making sure that no other checkboxes
     * is selected by randomly checking for "Accommodations" and "Pet" button 
     * to be off. 
     * After Continue is clicked The Url changes to results page and is not longer
     * in main page "/" 
     * @test
     * 
     * 
     * @return void
     */
   

    public function check_box_ada_lgbtqa_religious_validation()
    {


        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Portland Aid Guide')
                    ->press('Search')
                  
                    ->whenAvailable('.modal', function($modal){
                        $modal->assertSee('Search')
                        ->maximize()
    
                        ->clickAtPoint($x = 733, $y = 356)
                        ->assertRadioSelected('Gender','Male')
                        ->check('ADA')
                        ->assertChecked('ADA')
                        ->check('LGBTQA+ resource')
                        ->assertChecked('LGBTQA+ resource') 
                        ->check('Religious expectations')
                        ->assertChecked('Religious expectations')  
                        ->assertNotChecked('Accommodations for families')
                        ->assertNotChecked('Pet friendly')
                        ->press('Continue')
                        ->assertPathIsNot('/')
                        ->assertPathIs('/results')
                        ->assertPathIs($this->url());
                    
                    });
        });
    }
}
