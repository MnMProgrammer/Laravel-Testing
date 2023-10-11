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
        // Creating a project
        $project = Project::factory('App\Models\Project')->create();

        // Asserting that the path will equal the id a the project
        $this->assertEquals('/projects/' . $project->id, $project->path());
    }
    
    /** @test */
    public function belongs_to_owner()
    {
        // Creating a project
        $project = Project::factory('App\Models\Project')->create();

        $this->assertInstanceof('App\Models\User', $project->owner);
    }
}
