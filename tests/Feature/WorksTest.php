<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Skill;
use App\Livewire\Work;
use App\Models\Work as WorkModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use App\Models\Image;
use Illuminate\Support\Facades\Log;

class WorksTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test can display works page
     */
    public function test_can_display_works_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/works');

        $response->assertStatus(200);
    }

    /**
     *  Test can fetch a list of works
     */
    public function test_can_fetch_works()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/works');

        $response->assertStatus(200)
            ->assertViewIs('admin.works');

    }

    /**
     * Test can authenticated user add works
     */
    public function test_authenticated_user_can_add_works()
    {

        $user = User::factory()->create();

        $php = Skill::create([
            'name' => 'PHP',
            'description' => 'This is JS',
            'icon' => 'fa-php',
            'user_id' => $user->id
        ]);

        $js = Skill::create([
            'name' => 'JS',
            'description' => 'This is JS',
            'icon' => 'fa-js',
            'user_id' => $user->id
        ]);

        Storage::fake('works_photos');

        $photo = UploadedFile::fake()->image('photo.jpg');

        Livewire::actingAs($user)
            ->test(Work::class)
            ->set('title', 'Patasente')
            ->set('description', 'Financial Application for SMEs')
            ->set('url', 'https://patasente.com')
            ->set('skills', [$php->id, $js->id])
            ->set('photo', $photo)
            ->call('save')
            ->assertHasNoErrors();

        $work = WorkModel::first();
        $image = $work->image;
        $stored_path = $image->url;

        Storage::disk('public')->assertExists($stored_path);

        $this->assertDatabaseCount('works', 1);

        $this->assertDatabaseHas('works',[
            'title' => 'Patasente',
            'description' => 'Financial Application for SMEs',
        ]);


    }

    /**
     * Test can authenticated user add works
     */
    public function test_only_allowed_image_mimes_can_be_added_on_works()
    {

        $user = User::factory()->create();

        $php = Skill::create([
            'name' => 'PHP',
            'description' => 'This is JS',
            'icon' => 'fa-php',
            'user_id' => $user->id
        ]);

        $js = Skill::create([
            'name' => 'JS',
            'description' => 'This is JS',
            'icon' => 'fa-js',
            'user_id' => $user->id
        ]);

        Storage::fake('works_photos');

        $photo = UploadedFile::fake()->create('photo.pdf','100', 'application/pdf');

        Livewire::actingAs($user)
            ->test(Work::class)
            ->set('title', 'Patasente')
            ->set('description', 'Financial Application for SMEs')
            ->set('url', 'https://patasente.com')
            ->set('skills', [$php->id, $js->id])
            ->set('photo', $photo)
            ->call('save')
            ->assertHasErrors(['photo']);

    }


    /**
     * Test guest users cannot add works
     */
    public function test_guest_user_cannot_add_works()
    {

        $user = User::factory()->create();

        $php = Skill::create([
            'name' => 'PHP',
            'description' => 'This is PHP',
            'icon' => 'fa-php',
            'user_id' => $user->id
        ]);

        $js = Skill::create([
            'name' => 'JS',
            'description' => 'This is JS',
            'icon' => 'fa-js',
            'user_id' => $user->id
        ]);

        Livewire::test(Work::class)
            ->set('title', 'Patasente')
            ->set('description', 'Financial Application for SMEs')
            ->set('url', 'https://patasente.com')
            ->set('skills', [$php->id, $js->id])
            ->call('save')
            ->assertForbidden();

    }

    /**
     * Test title is required
     */
    public function test_title_is_required()
    {

        $user = User::factory()->create();

        $php = Skill::create([
            'name' => 'PHP',
            'description' => 'This is PHP',
            'icon' => 'fa-php',
            'user_id' => $user->id
        ]);

        $js = Skill::create([
            'name' => 'JS',
            'description' => 'This is JS',
            'icon' => 'fa-js',
            'user_id' => $user->id
        ]);

        Livewire::actingAs($user)
            ->test(Work::class)
            ->set('description', 'This is ML')
            ->set('skills', [$php->id, $js->id])
            ->call('save')
            ->assertHasErrors();

    }

    /**
     * Description is required
     */
    public function test_description_is_required()
    {

        $user = User::factory()->create();

        $php = Skill::create([
            'name' => 'PHP',
            'description' => 'This is PHP',
            'icon' => 'fa-php',
            'user_id' => $user->id
        ]);

        $js = Skill::create([
            'name' => 'JS',
            'description' => 'This is JS',
            'icon' => 'fa-js',
            'user_id' => $user->id
        ]);

        Livewire::actingAs($user)
            ->test(Work::class)
            ->set('title','Data Ops')
            ->set('skills', [$php->id, $js->id])
            ->call('save')
            ->assertHasErrors();

    }


    /**
     * Test title is a string
     */
    public function test_title_is_a_string()
    {

        $user = User::factory()->create();

        $php = Skill::create([
            'name' => 'PHP',
            'description' => 'This is PHP',
            'icon' => 'fa-php',
            'user_id' => $user->id
        ]);

        $js = Skill::create([
            'name' => 'JS',
            'description' => 'This is JS',
            'icon' => 'fa-js',
            'user_id' => $user->id
        ]);

        Livewire::actingAs($user)
            ->test(Work::class)
            ->set('title', 12343)
            ->set('description', 'This is ML')
            ->set('skills', [$php->id, $js->id])
            ->call('save')
            ->assertHasErrors(['title' => 'string']);

    }

    /**
     * Description is a string
     */
    public function test_description_is_a_string()
    {

        $user = User::factory()->create();

        $php = Skill::create([
            'name' => 'PHP',
            'description' => 'This is PHP',
            'icon' => 'fa-php',
            'user_id' => $user->id
        ]);

        $js = Skill::create([
            'name' => 'JS',
            'description' => 'This is JS',
            'icon' => 'fa-js',
            'user_id' => $user->id
        ]);

        Livewire::actingAs($user)
            ->test(Work::class)
            ->set('title','Data Ops')
            ->set('description',234234)
            ->set('skills', [$php->id, $js->id])
            ->call('save')
            ->assertHasErrors(['description' => 'string']);

    }

    /**
     * Skill is an array
     */
    public function test_skills_is_an_array()
    {

        $user = User::factory()->create();


        Livewire::actingAs($user)
            ->test(Work::class)
            ->set('title','Data Ops')
            ->set('description','This is ML')
            ->set('skills', 2342)
            ->call('save')
            ->assertHasErrors(['skills' => 'array']);

    }


    /**
     * Test authenticated user can delete works
     */
    public function test_authenticated_user_can_delete_works()
    {
        $user = User::factory()->create();

        $php = Skill::create([
            'name' => 'PHP',
            'description' => 'This is PHP',
            'icon' => 'fa-php',
            'user_id' => $user->id
        ]);

        $js = Skill::create([
            'name' => 'JS',
            'description' => 'This is JS',
            'icon' => 'fa-js',
            'user_id' => $user->id
        ]);

        $work = WorkModel::create([
            'title' => 'Binjii',
            'description' => 'This is an ecommence platform',
            'user_id' => $user->id,
            'photo' => 'photo.jpg'
        ]);

        $work->skills()->attach([$php->id, $js->id]);

        Livewire::actingAs($user)
            ->test(Work::class)
            ->call('delete', $work->id)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('works', [
            'id' => $work->id
        ]);

    }

    /**
     * Test guests cannot delete works
     */
    public function test_guest_cannot_delete_works()
    {
        $user = User::factory()->create();

        $php = Skill::create([
            'name' => 'PHP',
            'description' => 'This is PHP',
            'icon' => 'fa-php',
            'user_id' => $user->id
        ]);

        $js = Skill::create([
            'name' => 'JS',
            'description' => 'This is JS',
            'icon' => 'fa-js',
            'user_id' => $user->id
        ]);

        $work = WorkModel::create([
            'title' => 'Binjii',
            'description' => 'This is an ecommence platform',
            'user_id' => $user->id
        ]);

        $work->skills()->attach([$php->id, $js->id]);

        Livewire::test(Work::class)
            ->call('delete', $work->id)
            ->assertForbidden();
    }


    /**
     * Test can authenticated user update works
     */
    public function test_authenticated_user_can_update_works()
    {

        $user = User::factory()->create();

        $php = Skill::create([
            'name' => 'PHP',
            'description' => 'This is JS',
            'icon' => 'fa-php',
            'user_id' => $user->id
        ]);

        $js = Skill::create([
            'name' => 'JS',
            'description' => 'This is JS',
            'icon' => 'fa-js',
            'user_id' => $user->id
        ]);

        Storage::fake('works_photos');

        $photo = UploadedFile::fake()->image('photo.jpg');

        $work = WorkModel::create([
            'title' => 'Patasente',
            'description' => 'Financial Application for SMEs',
            'user_id' => $user->id
        ]);

        $work->skills()->attach([$php->id, $js->id]);

        if ( ! empty($photo) ) {
            Image::create([
                'url' => $photo->store('works_photos', 'public'),
                'imageable_id' => $work->id,
                'imageable_type' =>  WorkModel::class
            ]);
        }

        $this->assertDatabaseCount('works', 1);

        $this->assertDatabaseHas('works',[
            'title' => 'Patasente',
            'description' => 'Financial Application for SMEs',
        ]);

        $new_photo = UploadedFile::fake()->image('new_photo.jpg');

        Livewire::actingAs($user)
            ->test(Work::class)
            ->call('edit', $work->id)
            ->set('title', 'Binjii')
            ->set('description', 'E-commence app')
            ->set('photo', $new_photo)
            ->call('save')
            ->assertHasNoErrors();

        $work = WorkModel::first();
        $image = $work->image;
        $stored_path = $image->url;

        Storage::disk('public')->assertExists($stored_path);

        $this->assertDatabaseCount('works', 1);

        $this->assertDatabaseHas('works',[
            'title' => 'Binjii',
            'description' => 'E-commence app',
        ]);


    }

}
