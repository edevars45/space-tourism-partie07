<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

// Pages publiques (maquette)
use App\Http\Controllers\DestinationsController;
use App\Http\Controllers\PublicCrewController;

// Espace authentifié (Breeze)
use App\Http\Controllers\ProfileController;

// Back-office (Partie 07)
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TechnologyController;
use App\Http\Controllers\Admin\PlanetController;
use App\Http\Controllers\Admin\CrewMemberController;

/*
|--------------------------------------------------------------------------
| 1) Pages publiques (accès libre)
|--------------------------------------------------------------------------
*/
Route::view('/', 'pages.home')->name('home');

// Destinations
Route::redirect('/destinations', '/destinations/moon')->name('destinations');
Route::get('/destinations/{planet?}', [DestinationsController::class, 'show'])
    ->name('destinations.show');

// Équipage public (fallback i18n si BDD vide)
Route::get('/crew', [PublicCrewController::class, 'index'])->name('crew');

// Technologies publiques (page maquette)
Route::view('/technology', 'pages.technology')->name('technology');

/*
|--------------------------------------------------------------------------
| 2) Espace authentifié (Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'pages.home')->name('dashboard');

    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes (login/register/verify/etc.)
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| 3) Commutateur de langue FR/EN
|--------------------------------------------------------------------------
*/
Route::get('/lang/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['fr','en']), 404);
    Session::put('locale', $locale);
    App::setLocale($locale);
    return back();
})->name('lang.switch');

/*
|--------------------------------------------------------------------------
| 4) Back-office — auth + verified + rôles/permissions
|--------------------------------------------------------------------------
| Noms générés automatiquement : admin.users.*, admin.technologies.*, admin.planets.*, admin.crew.*
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', ])
    ->group(function () {

        // Utilisateurs — réservé aux Administrateurs
        Route::middleware(['role:Administrateur'])->group(function () {
            Route::resource('users', UserController::class)->except(['show']);
        });

        // Technologies — permission:technologies.manage
        Route::middleware(['permission:technologies.manage'])->group(function () {
            Route::resource('technologies', TechnologyController::class)->except(['show']);

            // Actions additionnelles
            Route::post('technologies/{technology}/move-up',   [TechnologyController::class, 'moveUp'])->name('technologies.moveUp');
            Route::post('technologies/{technology}/move-down', [TechnologyController::class, 'moveDown'])->name('technologies.moveDown');
            Route::post('technologies/bulk',                   [TechnologyController::class, 'bulk'])->name('technologies.bulk');
            Route::post('technologies/reorder',                [TechnologyController::class, 'reorder'])->name('technologies.reorder');
        });

        // Planètes — permission:planets.manage
        Route::middleware(['permission:planets.manage'])->group(function () {
            Route::resource('planets', PlanetController::class)->except(['show']);
        });

        // Équipage — permission:crew.manage
        Route::middleware(['permission:crew.manage'])->group(function () {
            Route::resource('crew', CrewMemberController::class)->except(['show']);
        });
    });
