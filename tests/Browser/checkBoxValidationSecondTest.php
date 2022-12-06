<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class checkBoxValidationSecondTest extends DuskTestCase
{
  /**
    * @return string
    */
    public function url()
    {
        return '/results';
    }

  /**
     * Test to validate "sober", "pet", and "families" checkboxes 
     * with "female" gender selected. Making sure that no other checkboxes
     * is selected by randomly checking for "Accommodations" and "Pet" button 
     * to be off. 
     * After Continue is clicked The Url changes to results page and is not longer
     * in main page "/"      
     * @test
     * 
     * 
     * @return void
     */
   

    public function check_box_sober_pet_families_validation()
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
                        ->check('Sober living')
                        ->assertChecked('Sober living')
                        ->check('Pet friendly')
                        ->assertChecked('Pet friendly') 
                        ->check('Accommodations for families')
                        ->assertChecked('Accommodations for families') 
                        ->assertNotChecked('LGBTQA+ resource')
                        ->assertNotChecked('Religious expectations') 
                        ->press('Continue')
                        ->assertPathIsNot('/')
                        ->assertPathIs('/results')
                        ->assertPathIs($this->url());
                    
                    });
        });
    }
}
