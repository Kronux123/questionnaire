<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionnaireController;
use App\Models\Questionare;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/questionnaires', [QuestionnaireController::class, 'index'])->name('questionnaires.create');
    Route::post('/questionnaires/save', [QuestionnaireController::class, 'save'])->name('questionnaires.save');
    Route::delete('/questionnaires/{id}', [QuestionnaireController::class, 'destroy'])->name('questionnaires.destroy');
    Route::get('/questionnaires/view/{id}', [QuestionnaireController::class, 'view'])->name('questionnaires.view');

    Route::get('/dashboard', function () {
        $questionnaires = Questionare::with('questions.choices')
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->get();
        return Inertia::render('Dashboard', [
            'questionnaires' => $questionnaires
        ]);
    })->middleware('verified')->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
