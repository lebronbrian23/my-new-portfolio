<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/skills', 'skills')->name('skills');
Route::view('/works', 'works')->name('works');
Route::view('/navigation-links', 'navigation-links')->name('navigation-links');
Route::view('/content-blocks', 'content-block')->name('content-blocks');
Route::view('/contact', 'contact')->name('contacts');
Route::view('/about', 'about')->name('about');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::view('/admin', 'dashboard');

    Route::view('/admin/skills', 'admin.skills')->name('admin.skills');
    Route::view('/admin/works', 'admin.works')->name('admin.works');
    Route::view('/admin/navigation-links', 'admin.navigation-links')->name('admin.navigation-links');
    Route::view('/admin/content-blocks', 'admin.content-block')->name('admin.content-blocks');
    Route::view('/admin/contact', 'admin.contact')->name('admin.contacts');
    Route::view('/admin/about', 'admin.about')->name('admin.about');
    Route::view('/admin/resume', 'admin.resume')->name('admin.resume');

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
