<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class genderinputMaleTest extends DuskTestCase
{
    /**
    * @return string
    */
    public function url()
    {
        return '/results';
    }

    /**
     * Test to validate "Male" button under gender. 
     * All other checkboxes are off
     * validate that url is changed to results page
     * @test
     * 
     * 
     * @return void
     */
    public function gender_input_male_validation()
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
                        ->press('Continue')
                        ->assertPathIsNot('/')
                        ->assertPathIs('/results')
                        ->assertPathIs($this->url());
                    
                    });
        });
    }
}
