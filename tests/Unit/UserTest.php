<?php

namespace Tests\Unit;

use Session;
use App\Models\User;
use App\Models\Project;
use Tests\TestCase; 

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_has_projects()
    {        
        // Create a user using the factory
        $user = User::factory()->create();

        // User can access the projects
        $this->assertInstanceOf(Collection::class, $user->projects);
    }
}
