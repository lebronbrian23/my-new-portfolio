<?php

namespace Tests\Feature;

use App\Livewire\NavigationLink;
use App\Models\NavigationLink as NavigationLinkModel;
use App\Models\User;
use App\Models\ContentBlock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;

class NavigationLinksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test can fetch navigation links
     */
    public function test_can_fetch_navigation_links()
    {
        $user = User::factory()->create();

        $link = NavigationLinkModel::create([
            'link_name' => "Skills",
            'link_route' => "skills",
            'link_icon' => "bolt",
            'link_position' => 4,
            'user_id' => $user->id
        ]);


        $content = ContentBlock::create([
            'title' => 'Bobi Wine',
            'description' => 'My bio',
            'photo' => 'content_block.jpg',
            'user_id' => $user->id,
            'content_block_section' => 'about',
            'navigation_link_id' => $link->id
        ]);

        $response = $this->get('navigation-links');

        $response->assertStatus(200)
            ->assertViewIs('navigation-links');

    }

    /**
     * Test can add a navigation link
     */
    public function test_can_add_a_navigation_link()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(NavigationLink::class)
            ->set('link_name', 'Home')
            ->set('link_route', 'skills')
            ->set('link_icon', 'bolt')
            ->set('link_position', 1)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('navigation_links', 1);

        $this->assertDatabaseHas('navigation_links',[
            'link_name' => 'Home',
            'link_route' => 'skills',
            'link_position' => 1
        ]);

    }

    /**
     * Test guests cannot add a navigation link
     */
    public function test_guest_cannot_add_navigation_link()
    {
        Livewire::test(NavigationLink::class)
            ->set('link_name', 'Home')
            ->set('link_route', 'skills')
            ->set('link_icon', 'bolt')
            ->set('link_position', 1)
            ->call('save')
            ->assertForbidden();
    }

    /**
     * Test link name is required
     */
    public function test_navigation_link_name_is_required()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(NavigationLink::class)
            ->set('link_name', '')
            ->set('link_route', 'skills')
            ->set('link_icon', 'bolt')
            ->set('link_position', 1)
            ->call('save')
            ->assertHasErrors();
    }

    /**
     * Test link route is required
     */
    public function test_navigation_link_route_is_required()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(NavigationLink::class)
            ->set('link_name', 'Home')
            ->set('link_route', '')
            ->set('link_position', 1)
            ->set('link_icon', 'bolt')
            ->call('save')
            ->assertHasErrors();
    }

    /**
     * Test link name is a string
     */
    public function test_navigation_link_name_is_string()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(NavigationLink::class)
            ->set('link_name', 234322)
            ->set('link_route', 'skills')
            ->set('link_position', 1)
            ->call('save')
            ->assertHasErrors(['link_name' => 'string']);
    }

    /**
     * Test link route is a string
     */
    public function test_navigation_link_route_is_string()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(NavigationLink::class)
            ->set('link_name', 'Home')
            ->set('link_route', 234132)
            ->set('link_position', 1)
            ->call('save')
            ->assertHasErrors(['link_route' => 'string']);
    }

    /**
     * Test link route is a string
     */
    public function test_navigation_link_position_is_integer()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(NavigationLink::class)
            ->set('link_name', 'Home')
            ->set('link_route', 'skills')
            ->set('link_position', 'Home233')
            ->call('save')
            ->assertHasErrors(['link_position' => 'integer']);
    }

    /**
     * Test can update navigation link
     */
    public function test_can_update_navigation_link()
    {
        $user = User::factory()->create();

        $link = NavigationLinkModel::create([
            'link_name' => "Home",
            'link_route' => "skills",
            'link_icon' => "bolt",
            'link_position' => 2,
            'user_id' => $user->id
        ]);

        $this->assertDatabaseCount('navigation_links', 1);

        Livewire::actingAs($user)
            ->test(NavigationLink::class)
            ->set('link_name', 'Home')
            ->set('link_route', 'skills')
            ->set('link_position', 1)
            ->set('link_icon', 'bolt')
            ->call('save', $link->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('navigation_links',[
            'link_name' => "Home",
            'link_route' => "skills",
            'link_icon' => "bolt",
            'link_position' => 1,
            'user_id' => $user->id
        ]);


    }
    /**
     * Test guest cannot update navigation link
     */
    public function test_guest_cannot_update_navigation_link()
    {
        $user = User::factory()->create();

        $link = NavigationLinkModel::create([
            'link_name' => "Home",
            'link_route' => "skills",
            'link_position' => 2,
            'user_id' => $user->id
        ]);

        $this->assertDatabaseCount('navigation_links', 1);

        Livewire::test(NavigationLink::class)
            ->set('link_name', 'Home')
            ->set('link_route', 'skills')
            ->set('link_icon', 'bolt')
            ->set('link_position', 1)
            ->call('save', $link->id)
            ->assertForbidden();

    }

    /**
     * Test can delete a navigation link
     */
    public function test_can_delete_navigation_link()
    {
        $user = User::factory()->create();

        $link = NavigationLinkModel::create([
            'link_name' => "Home",
            'link_route' => "skills",
            'link_icon' => "bolt",
            'link_position' => 2,
            'user_id' => $user->id
        ]);

        $this->assertDatabaseCount('navigation_links', 1);

        Livewire::actingAs($user)
            ->test(NavigationLink::class)
            ->call('delete', $link->id)
            ->assertHasNoErrors();

        $this->assertDatabaseCount('navigation_links',0);


    }
    /**
     * Test guest cannot delete navigation link
     */
    public function test_guest_cannot_delete_navigation_link()
    {
        $user = User::factory()->create();

        $link = NavigationLinkModel::create([
            'link_name' => "Home",
            'link_route' => "skills",
            'link_icon' => "bolt",
            'link_position' => 2,
            'user_id' => $user->id
        ]);

        $this->assertDatabaseCount('navigation_links', 1);

        Livewire::test(NavigationLink::class)
            ->call('delete', $link->id)
            ->assertForbidden();

    }
}
