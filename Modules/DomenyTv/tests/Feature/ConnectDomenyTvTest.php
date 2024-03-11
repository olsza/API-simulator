<?php

namespace Modules\DomenyTv\tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConnectDomenyTvTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testExample(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testDomenyTvModule()
    {
        $response = $this->get(route('api.domenytv'));

        $response->assertStatus(200);
    }
}
