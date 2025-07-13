<?php

namespace Tests\Unit;

use Tests\TestCase;

class DatabaseConnectionTest extends TestCase
{
    /** @test */
    public function it_confirms_testing_database_is_sqlite()
    {
        $this->assertEquals('sqlite', config('database.default'));
        $this->assertEquals(':memory:', config('database.connections.sqlite.database'));
    }
}
