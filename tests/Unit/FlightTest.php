<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FlightTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testFlightLogs()
    {
        $response = $this->get('/api/getLiveFlightsLog?east=9999&west=-9999&north=9999&south=-9999');
        $response->assertStatus(200)->assertJson([
            'status' => 200,
        ])->assertJsonCount(20,'flights')->assertJsonCount(69,'airports');
    }

    public function testGetFlightInfo()
    {
        $response = $this->get('/api/getFlightInfo/15');
        $response->assertStatus(200)->assertJson([
            'status' => 200,
        ]);
    }

    public function testGetAirportInfo()
    {
        $response = $this->get('/api/getAirportInfo/4');
        $response->assertStatus(200)->assertJson([
            'status' => 200,
        ]);
    }
}
