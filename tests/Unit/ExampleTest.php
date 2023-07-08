<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAllEvents()
    {
        $response = $this->json('GET', 'api/event');
        $response->assertStatus(200);
    }
    public function testCreateEvent()
    {
        $data = [
            'title' => "New Event",
            'description' => "long description",
            'startDate' => '2023-07-08',
            'endDate' => '2023-07-14'
        ];

        $response = $this->post( 'api/event', $data);
        $response->assertStatus(200);
        $response->assertJson(['error' => false]);
        $response->assertJson(['message' => 'success']);
        $response->assertJson(['data' => []]);
    }
    public function testUpdateEvent()
    {
        $data = [
            'title' => "New Event",
            'description' => "long description",
            'startDate' => '2023-07-08',
            'endDate' => '2023-07-14'
        ];

        $response = $this->put('api/event/16', $data);
        $response->assertStatus(200);
        $response->assertJson(['error' => false]);
        $response->assertJson(['message' => 'success']);
        $response->assertJson(['data' => []]);

    }

    public function testDeleteEvent()
    {
        $response = $this->delete('api/event/16');
        $response->assertStatus(200);
        $response->assertJson(['error' => false]);
        $response->assertJson(['message' => 'success']);
        $response->assertJson(['data' => []]);
    }
    public function test_get_base_method(){
        $response = $this->get('/api/event');
        $response->assertStatus(200);
    }
}
