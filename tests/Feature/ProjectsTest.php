<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_project()
    {

        // Whenever an exception is thrown provide the full details
        $this->withoutExceptionHandling();

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            
        ];

        // Checking for a endpoint on the url
        $this->post('/projects', $attributes);

        // Checking for a database, table and columns 
        $this->assertDatabaseHas('projects', $attributes);

        // If I make a get request to this url then I check that I can see the following attribute
        $this->get('/projects')->assertSee($attributes['title']);
    }
}
