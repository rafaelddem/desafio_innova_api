<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HeroTest extends TestCase
{
    use DatabaseTransactions;

    public function test_list_successfully(): void
    {
        $response = $this->get(route('list'))
            ->assertStatus(200);

        $this->assertIsArray($response->json('heroes'));
        $this->assertTrue(count($response->json('heroes')) > 10);
    }
}
