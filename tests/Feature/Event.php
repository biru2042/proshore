<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Event extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_event_get_response()
    {
        $response = $this->get('/api/event');

        $response->assertStatus(200);
    }

    public function create_a_event_record(){
        $event = Event::factory()->create();
        

    }
}
