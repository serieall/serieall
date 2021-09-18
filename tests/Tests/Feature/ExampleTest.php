<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * ExampleTest.
 */
class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        var_dump(phpversion());
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}