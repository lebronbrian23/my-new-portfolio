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

Route::view('/skills', 'skills')->name('skills');
Route::view('/works', 'works')->name('works');
Route::view('/navigation-links', 'navigation-links')->name('navigation-links');
Route::view('/content-block', 'content-block')->name('content-blocks');
Route::view('/contact', 'contact')->name('contact');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {



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
