<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectAssignmentController extends Controller
{
    /**
     * Muestra la vista de asignación.
     */
    public function index()
    {
        return view('asignar.index'); // Vista de asignación
    }

    /**
     * Retorna los datos de proyectos con usuarios asignados para Datatables.
     */
    public function getProjects()
    {
        $projects = Project::with('users')->get();
    
        return datatables()->of($projects)
            ->addColumn('actions', function ($project) {
                $users = User::all(); // Obtener usuarios para el modal de asignación
                return view('asignar.action', compact('project', 'users'))->render();
            })
            ->toJson();
    }

    /**
     * Asigna un usuario a un proyecto.
     */
    public function assignUser(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $project = Project::findOrFail($request->project_id);
        $project->users()->attach($request->user_id);

        return response()->json(['message' => 'Usuario asignado correctamente.']);
    }

    /**
     * Retira un usuario de un proyecto.
     */
    public function removeUser(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $project = Project::findOrFail($request->project_id);
        $project->users()->detach($request->user_id);

        return response()->json(['message' => 'Usuario retirado correctamente.']);
    }
}
