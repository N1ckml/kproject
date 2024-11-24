<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

    // Rutas específicas para las vistas
    Route::get('/usuarios', function () {
        return view('usuarios.index');
    })->name('usuarios.index');

    Route::get('/proyectos', function () {
        return view('proyectos.index');
    })->name('proyectos.index');

    Route::get('/fases', function () {
        return view('fases.index');
    })->name('fases.index');

    Route::get('/tareas', function () {
        return view('tareas.index');
    })->name('tareas.index');

    Route::get('/asignar', function () {
        return view('asignar.index');
    })->name('asignar.index');
});

require __DIR__.'/auth.php';
