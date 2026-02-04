<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Livewire\Skill;
use App\Models\Skill as SkillModel;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Support\Facades\Log;

class SkillsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if skills view displays.
     */
    public function test_skills_view_displays(): void
    {

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/skills');

        $response->assertStatus(200);
    }

    /**
     * Test can fetch a list of skills
     *
     */
    public function test_can_fetch_skills()
    {

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/skills');

        $response->assertStatus(200)
            ->assertViewIs('admin.skills');

    }

    /**
     * Test an authenticated user can add a skill
     */
    public function test_authenticated_user_can_add_a_skill()
    {

        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Skill::class)
            ->set('name', 'PHP')
            ->set('description', 'This is PHP')
            ->set('icon', 'fa-php')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('skills', 1);

        $this->assertDatabaseHas('skills', [
            'name' => 'PHP',
            'description' => 'This is PHP',
            'icon' => 'fa-php'
        ]);

    }

    /**
     * Test guests cannot add a skill
     */
    public function test_guests_cannot_add_a_skill()
    {

        Livewire::test(Skill::class)
            ->set('name', 'PHP')
            ->set('description', 'This is PHP')
            ->set('icon', 'fa-php')
            ->call('save')
            ->assertForbidden();

        $this->assertDatabaseCount('skills', 0);

    }


    /**
     * Test name is required
     */
    public function test_name_is_required()
    {

        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Skill::class)
            ->set('name','')
            ->call('save')
            ->assertHasErrors(['name' => 'required']);

    }

    /**
     * Test name is a string
     */
    public function test_name_is_string()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Skill::class)
            ->set('name',123423)
            ->call('save')
            ->assertHasErrors(['name' => 'string']);

    }

    /**
     * Test description is a string
     */
    public function test_description_is_string()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Skill::class)
            ->set('name','PHP')
            ->set('description',123423)
            ->call('save')
            ->assertHasErrors(['description' => 'string']);

    }

    /**
     * Test icon is a string
     */
    public function test_icon_is_string()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Skill::class)
            ->set('name','PHP')
            ->set('icon',123423)
            ->call('save')
            ->assertHasErrors(['icon' => 'string']);

    }

    /**
     * Test an authenticated user can update a skill
     */
    public function test_authenticated_user_can_update_a_skill()
    {

        $user = User::factory()->create();

        $skill = SkillModel::create([
            'name' => 'JS',
            'description' => 'This is JavaScript',
            'icon' => 'fa-js',
            'user_id' => $user->id
        ]);

        $this->assertDatabaseCount('skills', 1);

        Livewire::actingAs($user)
            ->test(Skill::class)
            ->call('edit', $skill->id)
            ->set('name', 'PHP')
            ->set('description', 'This is PHP')
            ->set('icon', 'fa-php')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('skills', [
            'name' => 'PHP',
            'description' => 'This is PHP',
            'icon' => 'fa-php'
        ]);

    }

    /**
     * Test guest cannot update a skill
     */
    public function test_guest_cannot_update_a_skill()
    {

        $user = User::factory()->create();

        $skill = SkillModel::create([
            'name' => 'JS',
            'description' => 'This is JavaScript',
            'icon' => 'fa-js',
            'user_id' => $user->id
        ]);

        $this->assertDatabaseCount('skills', 1);

        Livewire::test(Skill::class)
            ->set('name', 'PHP')
            ->set('description', 'This is PHP')
            ->set('icon', 'fa-php')
            ->call('save')
            ->assertForbidden();

    }

    /**
     * Test authenticated users can delete skill
     */
    public function test_authenticated_users_can_delete_skill()
    {
        $user = User::factory()->create();

        $skill = SkillModel::create([
            'user_id' => $user->id,
            'name' => 'PHP',
            'description' => 'This is PHP',
            'icon' => 'fa-php',
        ]);

        Livewire::actingAs($user)
            ->test(Skill::class)
            ->call('delete', $skill->id);

        $this->assertDatabaseMissing('skills',[
            'id' => $skill->id
        ]);

    }


    /**
     * Test guests cannot delete a skill
     */
    public function test_guests_cannot_delete_skill()
    {

        $user = User::factory()->create();

        $skill = SkillModel::create([
            'user_id' => $user->id,
            'name' => 'PHP',
            'description' => 'This is PHP',
            'icon' => 'fa-php',

        ]);

        Livewire::test(Skill::class)
            ->call('delete', $skill->id)
            ->assertForbidden();


    }
}
