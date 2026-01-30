<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ContentBlock as ContentBlockModel;
use App\Models\User;
use App\Models\NavigationLink;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use App\Livewire\ContentBlock;

class ContentBlocksTest extends TestCase
{
    use RefreshDatabase;

    public function test_content_block_page_displays(): void
    {
        $user = User::factory()->create();

        $link = NavigationLink::create([
            'link_name' => "Home",
            'link_route' => "/",
            'link_position' => 2,
            'user_id' => $user->id
        ]);

        ContentBlockModel::create([
            'title' => 'About Me',
            'description' => 'My bio',
            'photo' => 'content_block.jpg',
            'user_id' => $user->id,
            'content_block_section' => 'about',
            'content_block_status' => 'active',
            'navigation_link_id' => $link->id
        ]);

        $response = $this->get('/content-block');

        $response->assertStatus(200)
            ->assertViewIs('content-block');
    }

    public function test_authenticated_user_can_add_content_block_info()
    {
        $user = User::factory()->create();

        $link = NavigationLink::create([
            'link_name' => "Home",
            'link_route' => "/",
            'link_position' => 2,
            'user_id' => $user->id
        ]);

        Storage::fake('public');
        $photo = UploadedFile::fake()->image('content_block.jpg');

        Livewire::actingAs($user)
            ->test(ContentBlock::class)
            ->set('title', 'About me')
            ->set('description', 'I am a software developer')
            ->set('photo', $photo)
            ->set('content_block_section', 'about')
            ->set('content_block_status', 'active')
            ->set('navigation_link_id', $link->id)
            ->call('add')
            ->assertHasNoErrors();

        $content_block = ContentBlockModel::first();

        $this->assertNotNull($content_block);

        Storage::disk('public')->assertExists($content_block->photo);

        $this->assertDatabaseCount('content_blocks', 1);

        $this->assertDatabaseHas('content_blocks', [
            'title' => 'About me',
            'description' => 'I am a software developer',
            'content_block_section' => 'about',
            'content_block_status' => 'active',
            'navigation_link_id' => $link->id
        ]);
    }

    public function test_guest_cannot_add_content_block_info()
    {
        $user = User::factory()->create();
        $link = NavigationLink::create([
            'link_name' => "Home",
            'link_route' => "/",
            'link_position' => 2,
            'user_id' => $user->id
        ]);

        Storage::fake('public');
        $photo = UploadedFile::fake()->image('content_block.jpg');

        Livewire::test(ContentBlock::class)
            ->set('title', 'About me')
            ->set('description', 'I am a software developer')
            ->set('photo', $photo)
            ->set('content_block_section', 'about')
            ->set('content_block_status', 'active')
            ->set('navigation_link_id', $link->id)
            ->call('add')
            ->assertForbidden();
    }

    public function test_title_and_description_are_required()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(ContentBlock::class)
            ->call('add')
            ->assertHasErrors(['title', 'description']);
    }

    public function test_authenticated_user_can_update_content_block_info()
    {
        $user = User::factory()->create();

        $link1 = NavigationLink::create([
            'link_name' => "Home",
            'link_route' => "/",
            'link_position' => 2,
            'user_id' => $user->id
        ]);

        $link2 = NavigationLink::create([
            'link_name' => "Contact",
            'link_route' => "/contact",
            'link_position' => 4,
            'user_id' => $user->id
        ]);

        $content_block = ContentBlockModel::create([
            'title' => 'About Me',
            'description' => 'My bio',
            'photo' => 'content_block.jpg',
            'user_id' => $user->id,
            'content_block_section' => 'about',
            'content_block_status' => 'active',
            'navigation_link_id' => $link1->id
        ]);

        Storage::fake('public');
        $photo = UploadedFile::fake()->image('updated.jpg');

        Livewire::actingAs($user)
            ->test(ContentBlock::class)
            ->set('new_title', 'About Updated')
            ->set('new_description', 'Updated description')
            ->set('new_photo', $photo)
            ->set('new_content_block_section', 'about')
            ->set('new_content_block_status', 'inactive')
            ->set('new_navigation_link_id', $link2->id)
            ->call('update', $content_block->id)
            ->assertHasNoErrors();

        $updated = ContentBlockModel::first();

        $this->assertEquals('About Updated', $updated->title);
        $this->assertEquals('Updated description', $updated->description);
        $this->assertEquals('about', $updated->content_block_section);
        $this->assertEquals('inactive', $updated->content_block_status);
        $this->assertEquals($link2->id, $updated->navigation_link_id);

        Storage::disk('public')->assertExists($updated->photo);
    }

    public function test_guest_cannot_update_content_block_info()
    {
        $user = User::factory()->create();

        $link = NavigationLink::create([
            'link_name' => "Home",
            'link_route' => "/",
            'link_position' => 2,
            'user_id' => $user->id
        ]);

        $content_block = ContentBlockModel::create([
            'title' => 'About Me',
            'description' => 'My bio',
            'photo' => 'content_block.jpg',
            'user_id' => $user->id,
            'content_block_section' => 'about',
            'content_block_status' => 'active',
            'navigation_link_id' => $link->id
        ]);

        $photo = UploadedFile::fake()->image('updated.jpg');

        Livewire::test(ContentBlock::class)
            ->set('new_title', 'About Updated')
            ->set('new_description', 'Updated description')
            ->set('new_photo', $photo)
            ->set('new_content_block_section', 'about')
            ->set('new_content_block_status', 'inactive')
            ->set('new_navigation_link_id', $link->id)
            ->call('update', $content_block->id)
            ->assertForbidden();
    }

    public function test_authenticated_user_can_delete_content_block_info()
    {
        $user = User::factory()->create();

        $link = NavigationLink::create([
            'link_name' => "Home",
            'link_route' => "/",
            'link_position' => 2,
            'user_id' => $user->id
        ]);

        $content_block = ContentBlockModel::create([
            'title' => 'About Me',
            'description' => 'My bio',
            'photo' => 'content_block.jpg',
            'user_id' => $user->id,
            'content_block_section' => 'about',
            'content_block_status' => 'active',
            'navigation_link_id' => $link->id
        ]);

        Livewire::actingAs($user)
            ->test(ContentBlock::class)
            ->call('delete', $content_block->id)
            ->assertStatus(200);

        $this->assertDatabaseCount('content_blocks', 0);
    }

    public function test_guest_cannot_delete_content_block_info()
    {
        $user = User::factory()->create();

        $link = NavigationLink::create([
            'link_name' => "Home",
            'link_route' => "/",
            'link_position' => 2,
            'user_id' => $user->id
        ]);

        $content_block = ContentBlockModel::create([
            'title' => 'About Me',
            'description' => 'My bio',
            'photo' => 'content_block.jpg',
            'user_id' => $user->id,
            'content_block_section' => 'about',
            'content_block_status' => 'active',
            'navigation_link_id' => $link->id
        ]);

        Livewire::test(ContentBlock::class)
            ->call('delete', $content_block->id)
            ->assertForbidden();
    }
}
