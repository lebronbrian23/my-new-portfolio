<?php

namespace Tests\Feature;

use App\Livewire\Contact;
use App\Models\User;
use App\Models\Contact as ContactModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ContactsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_contact_page_displays(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/contacts');

        $response->assertStatus(200)
            ->assertViewIs('admin.contact');
    }

    /**
     * Test can authenticated user add a contact
     */
    public function test_can_authenticated_user_add_a_contact()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Contact::class)
            ->set('link', 'ssekalegga@gmail.com')
            ->set('type','email')
            ->set('icon', 'fa-email')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('contacts', 1);

        $this->assertDatabaseHas('contacts',[
            'link' => 'ssekalegga@gmail.com',
            'type' => 'email',
            'icon' => 'fa-email',
            'status' => 'active'
        ]);

    }

    /**
     * Test guest cannot add a contact
     */
    public function test_guest_cannot_add_a_contact()
    {

        Livewire::test(Contact::class)
            ->set('link', 'ssekalegga@gmail.com')
            ->set('type','email')
            ->set('icon', 'fa-email')
            ->call('save')
            ->assertForbidden();

    }

    /**
     * Test link and type are required
     */
    public function test_link_and_type_are_required()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Contact::class)
            ->set('icon', 'fa-email')
            ->call('save')
            ->assertHasErrors(['link', 'type']);

    }

    /**
     * Test can authenticated user update a contact
    */
    public function test_can_authenticated_user_update_a_contact()
    {
        $user = User::factory()->create();

        $contact = ContactModel::create([
            'icon' => 'fa-email',
            'type' => 'email',
            'link' => 'ssekalegga@gmail.com',
            'user_id' => $user->id
        ]);

        Livewire::actingAs($user)
            ->test(Contact::class)
            ->call('edit', $contact->id)
            ->set('link', 'lebronbrian@gmail.com')
            ->set('type','email')
            ->set('icon', 'fa-email')
            ->set('status', 'inactive')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('contacts', 1);

        $this->assertDatabaseHas('contacts',[
            'link' => 'lebronbrian@gmail.com',
            'type' => 'email',
            'icon' => 'fa-email',
            'status' => 'inactive'
        ]);

    }

    /**
     * Test guest cannot update a contact
    */
    public function test_guest_cannot_update_a_contact()
    {
        $user = User::factory()->create();

        $contact = ContactModel::create([
            'icon' => 'fa-email',
            'type' => 'email',
            'link' => 'ssekalegga@gmail.com',
            'user_id' => $user->id
        ]);

        $this->assertDatabaseCount('contacts', 1);

        Livewire::test(Contact::class)
            ->set('link', 'lebronbrian@gmail.com')
            ->set('type','email')
            ->set('icon', 'fa-email')
            ->set('status', 'inactive')
            ->call('save')
            ->assertForbidden();

    }


    /**
     * Test can authenticated user delete a contact
    */
    public function test_can_authenticated_user_delete_a_contact()
    {
        $user = User::factory()->create();

        $contact = ContactModel::create([
            'icon' => 'fa-email',
            'type' => 'email',
            'link' => 'ssekalegga@gmail.com',
            'user_id' => $user->id
        ]);

        Livewire::actingAs($user)
            ->test(Contact::class)
            ->call('delete', $contact->id)
            ->assertHasNoErrors();

        $this->assertDatabaseCount('contacts', 0);


    }

    /**
     * Test guest cannot update a contact
    */
    public function test_guest_cannot_delete_a_contact()
    {
        $user = User::factory()->create();

        $contact = ContactModel::create([
            'icon' => 'fa-email',
            'type' => 'email',
            'link' => 'ssekalegga@gmail.com',
            'user_id' => $user->id
        ]);

        Livewire::test(Contact::class)
            ->call('delete', $contact->id)
            ->assertForbidden();

    }


}
