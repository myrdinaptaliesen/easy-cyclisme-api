<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClubTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_new_club_created()
    {
        $response = $this->post('api/club', [
            'name_club' => 'US Pontchateau',
            'logo_club' => 'logo.png',
        ]);
        
        $response->assertStatus(200);
 
    }

    public function test_clubs_listed_successfully()
    {

        

        $this->json('GET', 'api/club', ['Accept' => 'application/json'])
            ->assertStatus(200);
            
    }
}
