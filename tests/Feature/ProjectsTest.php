<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Session;
use Tests\TestCase;
use App\Models\Project;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_project()
    {
        // Whenever an exception is thrown provide the full details
        $this->withoutExceptionHandling();

        $title = $this->faker->sentence;
        $description = $this->faker->paragraph;

        $tokenAttributes = [
            '_token' => csrf_token(),
            'title' => $title,
            'description' => $description,
        ];

        $attributes = [
            'title' => $title,
            'description' => $description,
        ];

        // Checking for a endpoint on the url and checking redirect
        $this->post('/projects', $tokenAttributes)->assertRedirect('/projects');

        // Checking for a database, table, columns, and inserted values
        $this->assertDatabaseHas('projects', $attributes);

        // Checking url for a get request then check that the following attribute is reachable
        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        // Going to the factory to get the fields and overriding the field to be blank
        $atrributes = Project::factory('App\Models\Project')->raw(['title' => '']);

        // Checking the post request to see if the follow field is passed, otherwise session has errors
        $this->post('/projects', $atrributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        // Going to the factory to get the fields and overriding the field to be blank
        $atrributes = Project::factory('App\Models\Project')->raw(['description' => '']);

        // Checking the post request to see if the follow field is passed, otherwise session has errors
        $this->post('/projects', $atrributes)->assertSessionHasErrors('description');
    }
}
