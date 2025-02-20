<?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Event;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_events_between_dates()
    {
        Event::factory()->create(['start_time' => now()->subDays(1), 'end_time' => now()->addDays(1)]);
        $response = $this->getJson('/api/events?start=' . now()->subDays(2) . '&end=' . now()->addDays(2));
        $response->assertStatus(200);
    }
}