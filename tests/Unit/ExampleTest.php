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
    public function test_that_true_is_true()
    {
        $response = $this->post('/api/event');
 
        // $response->assertStatus(200);
        // $response = $this->get('/api/event');
        // $this->assertTrue(true);
        // $response->assertStatus(200);
        $event = Event::factory()->create();
        $hasEvent = $event ? true : false;
        // $this->assertTrue($hasEvent);

        // $stock = new Event(['title'=>'Tesla', 'description'=>'sfsfsdf', 'startDate' => '2022-11-31', 'endDate' => '2022-12-01']);
        // $this->assertEquals('Tesla', $stock->name);

        // $response = $this->actingAs($event)->get('/event');

        // $response->assertStatus(200);

        // $response = $this->get('/event');
        $this->assertTrue(true);
    }
}
