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

        $response = $this->actingAs($user)->get('/admin/content-blocks');

        $response->assertStatus(200)
            ->assertViewIs('admin.content-block');
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
            ->call('save')
            ->assertHasNoErrors();

        $content_block = ContentBlockModel::first();

        $this->assertNotNull($content_block);

        Storage::disk('public')->assertExists($content_block->photo);

        $this->assertDatabaseCount('content_blocks', 1);

        // Assert basic fields in content_blocks table
        $this->assertDatabaseHas('content_blocks', [
            'title' => 'About me',
            'content_block_section' => 'about',
            'content_block_status' => 'active',
            'navigation_link_id' => $link->id
        ]);

        // Assert rich text description is stored in rich_texts table
        $this->assertDatabaseHas('rich_texts', [
            'record_type' => ContentBlockModel::class,
            'record_id' => $content_block->id,
            'field' => 'description',
            'body' => 'I am a software developer',
        ]);

        // Verify we can retrieve the description
        $this->assertEquals('I am a software developer', $content_block->description->toPlainText());
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
            ->call('save')
            ->assertForbidden();
    }

    public function test_title_and_description_are_required()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(ContentBlock::class)
            ->call('save')
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
            ->call('edit', $content_block->id)
            ->set('title', 'About Updated')
            ->set('description', 'Updated description')
            ->set('photo', $photo)
            ->set('content_block_section', 'about')
            ->set('content_block_status', 'inactive')
            ->set('navigation_link_id', $link2->id)
            ->call('save')
            ->assertHasNoErrors();

        // Refresh the model to get latest data
        $updated = $content_block->fresh();

        $this->assertEquals('About Updated', $updated->title);

        // For rich text fields, use toPlainText() or toHtml()
        $this->assertEquals('Updated description', $updated->description->toPlainText());

        $this->assertEquals('about', $updated->content_block_section);
        $this->assertEquals('inactive', $updated->content_block_status);
        $this->assertEquals($link2->id, $updated->navigation_link_id);

        Storage::disk('public')->assertExists($updated->photo);

        // Also verify in rich_texts table
        $this->assertDatabaseHas('rich_texts', [
            'record_type' => ContentBlockModel::class,
            'record_id' => $updated->id,
            'field' => 'description',
            'body' => 'Updated description',
        ]);
    }

    public function test_authenticated_user_can_update_content_block_without_changing_photo()
    {
        $user = User::factory()->create();

        $link = NavigationLink::create([
            'link_name' => "Home",
            'link_route' => "/",
            'link_position' => 2,
            'user_id' => $user->id
        ]);

        Storage::fake('public');
        $originalPhoto = UploadedFile::fake()->image('original.jpg');

        // Create content block with photo
        $content_block = ContentBlockModel::create([
            'title' => 'About Me',
            'description' => 'My bio',
            'photo' => $originalPhoto->store('content_block_photos', 'public'),
            'user_id' => $user->id,
            'content_block_section' => 'about',
            'content_block_status' => 'active',
            'navigation_link_id' => $link->id
        ]);

        $originalPhotoPath = $content_block->photo;

        // Update without changing photo
        Livewire::actingAs($user)
            ->test(ContentBlock::class)
            ->call('edit', $content_block->id)
            ->set('title', 'Updated Title')
            ->set('description', 'Updated bio')
            ->set('content_block_status', 'inactive')
            // Note: NOT setting photo here
            ->call('save')
            ->assertHasNoErrors();

        $updated = $content_block->fresh();

        $this->assertEquals('Updated Title', $updated->title);
        $this->assertEquals('Updated bio', $updated->description->toPlainText());
        $this->assertEquals('inactive', $updated->content_block_status);

        // Photo should remain unchanged
        $this->assertEquals($originalPhotoPath, $updated->photo);
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
            ->set('title', 'About Updated')
            ->set('description', 'Updated description')
            ->set('photo', $photo)
            ->set('content_block_section', 'about')
            ->set('content_block_status', 'inactive')
            ->set('navigation_link_id', $link->id)
            ->call('save')
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

        $contentBlockId = $content_block->id;

        Livewire::actingAs($user)
            ->test(ContentBlock::class)
            ->call('delete', $content_block->id)
            ->assertStatus(200);

        $this->assertDatabaseCount('content_blocks', 0);

        // Note: The HasRichText trait handles cascade delete through model events
        // The rich text records should be automatically deleted
        // However, this happens at the Eloquent level, not database level
        // Since we're using $content_block->delete() in the component
        // We need to verify the rich text was deleted
        $this->assertDatabaseMissing('rich_texts', [
            'record_type' => ContentBlockModel::class,
            'record_id' => $contentBlockId,
        ]);
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

    public function test_rich_text_description_stores_html()
    {
        $user = User::factory()->create();

        $link = NavigationLink::create([
            'link_name' => "Home",
            'link_route' => "/",
            'link_position' => 2,
            'user_id' => $user->id
        ]);

        Storage::fake('public');

        $htmlDescription = '<h1>Hello World</h1><p>This is <strong>bold</strong> text.</p>';

        Livewire::actingAs($user)
            ->test(ContentBlock::class)
            ->set('title', 'Rich Text Test')
            ->set('description', $htmlDescription)
            ->set('content_block_section', 'about')
            ->set('content_block_status', 'active')
            ->set('navigation_link_id', $link->id)
            ->call('save')
            ->assertHasNoErrors();

        $content_block = ContentBlockModel::first();

        // Verify HTML is preserved
        $this->assertStringContainsString('Hello World', $content_block->description->toHtml());
        $this->assertStringContainsString('<strong>bold</strong>', $content_block->description->toHtml());

        // Verify plain text strips HTML
        // Note: toPlainText() may include newlines/whitespace from HTML structure
        // Use a more flexible assertion
        $plainText = $content_block->description->toPlainText();
        $this->assertStringContainsString('Hello World', $plainText);
        $this->assertStringContainsString('This is bold text.', $plainText);

        // Or normalize whitespace for exact match
        $normalizedText = preg_replace('/\s+/', ' ', trim($plainText));
        $this->assertEquals('Hello World This is bold text.', $normalizedText);
    }
}
