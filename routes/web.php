<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectAssignmentController;
use App\Http\Controllers\TaskController;

// USUARIOS
Route::middleware('auth', 'role:admin')->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard'); // Asegúrate de tener una vista `dashboard.blade.php` en `resources/views`

    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/data', [UserController::class, 'getData'])->name('usuarios.data');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');

    Route::get('/proyectos', [ProjectController::class, 'index'])->name('proyectos.index');
    Route::get('/proyectos/data', [ProjectController::class, 'getData'])->name('proyectos.data');
    Route::post('/proyectos', [ProjectController::class, 'store'])->name('proyectos.store');
    Route::get('/proyectos/{id}', [ProjectController::class, 'show'])->name('proyectos.show');
    Route::put('/proyectos/{id}', [ProjectController::class, 'update'])->name('proyectos.update');
    Route::delete('/proyectos/{id}', [ProjectController::class, 'destroy'])->name('proyectos.destroy');

    //Route::get('/fases', [PhaseController::class, 'index'])->name('fases.index');
    Route::get('/tareas', [TaksController::class, 'index'])->name('tareas.index');
    //Route::get('/asignar', [AssignController::class, 'index'])->name('asignar.index');
});

Route::get('/fases', function () {
    return view('fases.index');
})->name('fases.index');

Route::get('/tareas', function () {
    return view('tareas.index');
})->name('tareas.index');

Route::get('/asignar', function () {
    return view('asignar.index');
})->name('asignar.index');

Route::middleware('auth', 'role:user')->group(function () {
    Route::view('/home-users', 'home-users')->name('home-users'); // Asegúrate de que `home-users.blade.php` esté en `resources/views`
});

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Proyectos:


Route::get('/asignar', [ProjectAssignmentController::class, 'index'])->name('asignar.index');
Route::get('/asignar/projects', [ProjectAssignmentController::class, 'getProjects'])->name('asignar.projects');
Route::post('/asignar/assign', [ProjectAssignmentController::class, 'assignUser'])->name('asignar.assign');
Route::post('/asignar/remove', [ProjectAssignmentController::class, 'removeUser'])->name('asignar.remove');



Route::middleware(['auth'])->group(function () {
    // Vista principal de tareas
    Route::get('/tareas', [TaskController::class, 'index'])->name('tareas.index');

    // Datos para la tabla (DataTables)
    Route::get('/tareas/data', [TaskController::class, 'getTasks'])->name('tareas.data');

    // Crear tarea
    Route::post('/tareas', [TaskController::class, 'store'])->name('tareas.store');

    // Actualizar tarea
    Route::put('/tareas/{task}', [TaskController::class, 'update'])->name('tareas.update');

    // Eliminar tarea
    Route::delete('/tareas/{task}', [TaskController::class, 'destroy'])->name('tareas.destroy');

    // Asignar tarea a una fase
    Route::post('/tareas/{task}/assign-phase', [TaskController::class, 'assignPhase'])->name('tareas.assignPhase');

    // Remover tarea de una fase
    Route::post('/tareas/{task}/remove-phase', [TaskController::class, 'removePhase'])->name('tareas.removePhase');
});

require __DIR__.'/auth.php';
