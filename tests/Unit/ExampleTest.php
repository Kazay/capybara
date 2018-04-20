<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Troupe;
use App\Models\Director;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function testDatabase()
    {
        $director = factory(\App\Models\Director::class, 20)->create();
        $troupe = factory(\App\Models\Troupe::class, 20)->create();
        $this->assertEquals(20, $this->getConnection()->table('directors')->count());
        $this->assertEquals(20, $this->getConnection()->table('troupes')->count());
    }
}
