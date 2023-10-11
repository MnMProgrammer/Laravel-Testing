<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Session;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guest_cannot_manage_projects()
    {
        // Whenever an exception is thrown provide the full details
        //$this->withoutExceptionHandling();

        // Going to the factory to get the fields and overriding the field to be blank
        $project = Project::factory('App\Models\Project')->create();

        // Checking if a non-authenticated user tried to access the general projects page
        $this->get('/projects')->assertRedirect('login');

        // Checking if a non-authenticated user tried to create a projects 
        $this->get('/projects/create')->assertRedirect('login');

        // Checking if a non-authenticated user tried to access a specific project page
        $this->get($project->path())->assertRedirect('login');

        // Checking the the user and redirecting to login page if not authenticated
        $this->post('/projects', $project->toArray())->assertRedirect('login');
        
        
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
    public function a_user_can_view_their_project()
    {
        // Creating temp user to check test
        $this->be(User::factory()->create());

        // Whenever an exception is thrown provide the full details
        $this->withoutExceptionHandling();

        // Creating a project
        $project = Project::factory('App\Models\Project')->create(['owner_id' => auth()->id()]);

        // Confirming that on the project detail page that the fields are visiable 
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

     /** @test */
    public function a_user_cannot_view_other_users_projects()
    {
        // Creating temp user to check test
        $this->be(User::factory()->create());
 
        // Whenever an exception is thrown provide the full details
        //$this->withoutExceptionHandling();
 
        // Creating a project
        $project = Project::factory('App\Models\Project')->create();
 
        // Confirming that on the project detail page that the fields are visiable 
        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        // Creating temp user to check test
        $this->be(User::factory()->create());

        // Whenever an exception is thrown provide the full details
        $this->withoutExceptionHandling();

        $tokenAttributes = [
            //'_token' => csrf_token(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'owner_id' => auth()->id()
        ];

        // Creating a project
        $project = Project::factory('App\Models\Project')->create($tokenAttributes);

        // Checking for a database, table, columns, and inserted values
        $this->assertDatabaseHas('projects', $tokenAttributes);

        // Checking url for a get request then check that the following attribute is reachable
        $this->get('/projects')->assertSee($tokenAttributes['title']);
    }
}
