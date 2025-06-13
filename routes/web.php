<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SummarizeController;


Route::get('/', [NoteController::class, 'index'])->name('home');

Route::get('/notes', [NoteController::class, 'getNotes'])->name('notes.index');
Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
Route::get('/notes/{id}/show', [NoteController::class, 'show'])->name('notes.show');
Route::get('/notes/{id}/edit', [NoteController::class, 'edit'])->name('notes.edit');
Route::put('/notes/{id}/update', [NoteController::class, 'update'])->name('notes.update');
Route::post('/notes/{id}/delete', [NoteController::class, 'destroy'])->name('notes.destroy');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::get('/auth/github/redirect', [GoogleController::class, 'redirect'])->name('github.redirect');
Route::get('/auth/github/callback', [GoogleController::class, 'callback'])->name('github.callback');

Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::get('/summarize', function (Request $request) {
    summarize($request);
});

// require __DIR__.'/auth.php';
