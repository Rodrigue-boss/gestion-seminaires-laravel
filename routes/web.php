<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/redirect', function () {
    $role = Auth::user()->role;

    return match ($role) {
        'présentateur' => redirect('/presentateur'),
        'secretaire' => redirect('/secretaire'),
        'étudiant' => redirect('/etudiant'),
        default => abort(403),
    };
});

require __DIR__.'/auth.php';

use App\Http\Controllers\Auth\RegisterController;

Route::post('/register', [RegisterController::class, 'store'])->name('register.custom');

use App\Http\Controllers\RedirectController;

use Illuminate\Support\Facades\Auth;
use App\Models\Seminaire;
use App\Models\User;
Route::get('/redirect', function () {
    $role = Auth::user()->role;

    if ($role === 'présentateur') {
        $seminaires = Seminaire::where('user_id', auth()->id())->get();
        return view('roles.presentateur', compact('seminaires'));
    }

    if ($role === 'secretaire') {
        // Ajoute ce que tu veux passer si besoin
        return view('roles.secretaire');
    }

    if ($role === 'étudiant') {
        $seminaires = Seminaire::where('publie', true)->get();
        return view('roles.etudiant', compact('seminaires'));
    }

    abort(403);
})->middleware('auth');


Route::get('/presentateur', function () {
    return 'Bienvenue Présentateur';
})->middleware(['auth', 'role:présentateur']);

Route::get('/secretaire', function () {
    return 'Bienvenue Secrétaire';
})->middleware(['auth', 'role:secretaire']);

/*Route::get('/etudiant', function () {
    return 'Bienvenue Étudiant';
})->middleware(['auth', 'role:étudiant']);*/
Route::get('/etudiant', function () {
    return view('roles.etudiant');
})->middleware(['auth', 'role:étudiant']);

use App\Http\Controllers\SeminaireController;

Route::middleware(['auth', 'role:présentateur'])->group(function () {
    Route::get('/seminaires/create', [SeminaireController::class, 'create'])->name('seminaires.create');
    Route::post('/seminaires', [SeminaireController::class, 'store'])->name('seminaires.store');
});
Route::get('/seminaires', [SeminaireController::class, 'index'])
    ->middleware(['auth', 'role:secretaire,présentateur'])
    ->name('seminaires.index');

Route::post('/seminaires/{id}/valider', [SeminaireController::class, 'valider'])
    ->middleware(['auth', 'role:secretaire'])
    ->name('seminaires.valider');

Route::post('/seminaires/{id}/rejeter', [SeminaireController::class, 'rejeter'])
    ->middleware(['auth', 'role:secretaire'])
    ->name('seminaires.rejeter');

Route::get('/seminaires/pdf', [SeminaireController::class, 'exportPDF'])
    ->middleware(['auth', 'role:secretaire,présentateur'])
    ->name('seminaires.export.pdf');

Route::get('/etudiant/seminaires', [SeminaireController::class, 'etudiantIndex'])
    ->middleware(['auth', 'role:étudiant'])
    ->name('etudiant.seminaires');

Route::get('/seminaires/{id}/resume', [SeminaireController::class, 'editerResume'])
    ->middleware(['auth', 'role:présentateur'])
    ->name('seminaires.resume');

Route::post('/seminaires/{id}/resume', [SeminaireController::class, 'mettreAJourResume'])
    ->middleware(['auth', 'role:présentateur'])
    ->name('seminaires.resume.update');

Route::post('/seminaires/{id}/publier', [SeminaireController::class, 'publier'])
    ->middleware(['auth', 'role:secretaire'])
    ->name('seminaires.publier');

Route::get('/seminaires/{id}/fichier', [SeminaireController::class, 'formFichier'])
    ->middleware(['auth', 'role:présentateur,secretaire'])
    ->name('seminaires.fichier.form');

Route::post('/seminaires/{id}/fichier', [SeminaireController::class, 'uploadFichier'])
    ->middleware(['auth', 'role:présentateur,secretaire'])
    ->name('seminaires.fichier.upload');


