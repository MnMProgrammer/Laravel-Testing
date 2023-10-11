<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Session;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function only_auth_users_can_create_projects()
    {
        // Whenever an exception is thrown provide the full details
        //$this->withoutExceptionHandling();

        // Going to the factory to get the fields and overriding the field to be blank
        $atrributes = Project::factory('App\Models\Project')->raw(['owner_id' => null]);

        // Checking the the user and redirecting to login page if not authenticated
        $this->post('/projects', $atrributes)->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        // Whenever an exception is thrown provide the full details
        //$this->withoutExceptionHandling();

        // Creating temp user to check test
        $user = User::factory()->create();
        $this->actingAs($user); 

        //$this->withoutExceptionHandling();

        $tokenAttributes = [
            //'_token' => csrf_token(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            //'owner_id' => '1'
        ] ;

        // Checking for a endpoint on the url and checking redirect
        //$this->post('/projects', $tokenAttributes)->assertRedirect('/projects');

        // Checking for a database, table, columns, and inserted values
        //$this->assertDatabaseHas('projects', $tokenAttributes);

        // // Checking url for a get request then check that the following attribute is reachable
        // $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        // Whenever an exception is thrown provide the full details
        //$this->withoutExceptionHandling();

        // Creating temp user to check test
        $user = User::factory()->create();
        $this->actingAs($user); 

        // Going to the factory to get the fields and overriding the field to be blank
        $atrributes = Project::factory('App\Models\Project')->raw(['title' => '']);
        $atrributes['_token'] = csrf_token();

        // Checking the post request to see if the follow field is passed, otherwise session has errors
        $this->post('/projects', $atrributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        // Creating temp user to check test
        $user = User::factory()->create();
        $user = $this->actingAs($user); 

        // Going to the factory to get the fields and overriding the field to be blank
        $atrributes = Project::factory('App\Models\Project')->raw(['description' => '']);

        // Checking the post request to see if the follow field is passed, otherwise session has errors
        $this->post('/projects', $atrributes)->assertSessionHasErrors('description');
    }

    /** @test */
    public function a_user_can_view_a_project()
    {
        // Whenever an exception is thrown provide the full details
        $this->withoutExceptionHandling();

        // Creating temp user to check test
        $user = User::factory()->create();
        $user = $this->actingAs($user); 

        // Creating a project
        $project = Project::factory('App\Models\Project')->create();

        // Confirming that on the project detail page that the fields are visiable 
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }
}
