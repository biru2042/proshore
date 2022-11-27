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
    public function test_get_base_method(){
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_that_true_is_true()
    {
        $response = $this->post('/api/event');
        $event = Event::factory()->create();
        $hasEvent = $event ? true : false;
        $this->assertTrue(true);
    }

    public function test_get_event_method(){
        $this->withExceptionHandling();
        $response = $this->get('/api/event');
        $this->assertEquals(3, count($response->json()));
    }
}
