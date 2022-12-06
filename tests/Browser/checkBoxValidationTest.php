<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class checkBoxValidationTest extends DuskTestCase
{
    /**
    * @return string
    */
    public function url()
    {
        return '/results';
    }

  /**
     * Test to validate "Referral", "Walkup", and "Fee" checkboxes 
     * with "All" gender selected. Making sure that no other checkboxes
     * is selected by randomly checking for "Accommodations" and "Pet" button 
     * to be off. 
     * After Continue is clicked The Url changes to results page and is not longer
     * in main page "/" 
     * @test
     * 
     * 
     * @return void
     */
   

    public function check_box_referral_walkup_fee_validation()
    {


        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Portland Aid Guide')
                    ->press('Search')
                  
                    ->whenAvailable('.modal', function($modal){
                        $modal->assertSee('Search')
                        ->maximize()
    
                        ->clickAtPoint($x = 896, $y = 356)
                        ->assertRadioSelected('Gender','All')
                        ->check('Referral / Reservation required')
                        ->assertChecked('Referral / Reservation required')
                        ->check('Walk-Up Availability')
                        ->assertChecked('Walk-Up Availability') 
                        ->check('Fee required')
                        ->assertChecked('Fee required') 
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
