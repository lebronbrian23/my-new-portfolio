<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Livewire\Skill;
use App\Livewire\Work;
use App\Livewire\Contact;
use App\Livewire\ContentBlock;
use App\Livewire\NavigationLink;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/skills', [Skill::class , 'render'])->name('skills');
Route::get('/works', [Work::class, 'render'])->name('works');
Route::get('/navigation-links', [NavigationLink::class, 'render'])->name('navigation-links');
Route::get('/content-block', [ContentBlock::class, 'render'])->name('content-blocks');
Route::get('/contact', [Contact::class, 'render'])->name('contact');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {


    Route::post('/add-skill', [Skill::class , 'add'])->name('add-skill');


    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');




});
