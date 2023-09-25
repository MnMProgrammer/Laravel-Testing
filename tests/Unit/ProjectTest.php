<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Session;
use Tests\TestCase;
use App\Models\Project;

class ProjectTest extends TestCase
{
   use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $project = Project::factory('App\Models\Project')->create();

        // Asserting that the path will equal the id a the project
        $this->assertEquals('/projects/' . $project->id, $project->path());
    }
}
