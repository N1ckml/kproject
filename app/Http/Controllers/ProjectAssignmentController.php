<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectAssignmentController extends Controller
{
    /**
     * Muestra el listado de proyectos y usuarios asociados.
     */
    public function index()
    {
        return view('asignar.index'); // Retorna la vista de asignación
    }

    /**
     * Retorna los datos para la tabla de proyectos (Datatables).
     */
    public function getProjects()
    {
        $projects = Project::with('users')->get();
    
        return datatables()->of($projects)
            ->addColumn('actions', function ($project) {
                $users = User::all(); // Obtener todos los usuarios para los modales
                return view('asignar.action', compact('project', 'users'))->render(); // Renderizar el contenido HTML del modal
            })
            ->rawColumns(['actions']) // Especificar que la columna 'actions' contiene HTML sin escapar
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

        $project = Project::find($request->project_id);
        $project->users()->attach($request->user_id);

        return response()->json(['message' => 'Usuario asignado al proyecto exitosamente.']);
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

        $project = Project::find($request->project_id);
        $project->users()->detach($request->user_id);

        return response()->json(['message' => 'Usuario retirado del proyecto exitosamente.']);
    }
}
