<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Http\Request;

class UserProjectsController extends Controller
{
    //
    public function index()
    {
        // Obtener los proyectos asociados al usuario logueado
        $projects = auth()->user()->projects;

        // Retornar la vista con los proyectos
        return view('home-users', compact('projects'));
    }

    public function show(Project $project)
    {
        // Cargar relaciones del proyecto: fases y tareas
        $project->load('phases.tasks');

        // Retornar la información del proyecto como JSON
        return response()->json($project);
    }
}
