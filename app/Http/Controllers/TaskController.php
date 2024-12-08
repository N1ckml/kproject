<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\Phase;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Muestra el listado de tareas.
     */
    public function index()
    {
        $projects = Project::all();
        $phases = Phase::all();
        return view('tareas.index', compact('projects', 'phases'));
    }

    /**
     * Retorna los datos para la tabla de tareas (Datatables).
     */
    public function getTasks(Request $request)
    {
        $tasks = Task::with(['project.phases', 'phase'])->get(); // Carga también las fases del proyecto
        $projects = Project::all(); // Esto ya está cargado correctamente
    
        return datatables()->of($tasks)
            ->addColumn('project', function ($task) {
                return $task->project->name;
            })
            ->addColumn('phase', function ($task) {
                return $task->phase ? $task->phase->name : 'Sin asignar';
            })
            ->addColumn('actions', function ($task) use ($projects) {
                return view('tareas.action', compact('task', 'projects'))->render();
            })
            ->rawColumns(['actions'])
            ->toJson();
    }
    /**
     * Crea una nueva tarea.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'phase_id' => 'nullable|exists:phases,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'required|boolean',
        ]);

        Task::create($request->all());

        return response()->json(['message' => 'Tarea creada exitosamente.']);
    }

    /**
     * Actualiza una tarea existente.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'phase_id' => 'nullable|exists:phases,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'required|boolean',
        ]);

        $task->update($request->all());

        return response()->json(['message' => 'Tarea actualizada exitosamente.']);
    }

    /**
     * Elimina una tarea.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(['message' => 'Tarea eliminada exitosamente.']);
    }

    /**
     * Asigna una tarea a una fase.
     */
    public function assignPhase(Request $request, Task $task)
    {
        $request->validate([
            'phase_id' => 'required|exists:phases,id',
        ]);

        $task->update(['phase_id' => $request->phase_id]);

        return response()->json(['message' => 'Fase asignada exitosamente.']);
    }

    /**
     * Remueve una tarea de una fase.
     */
    public function removePhase(Task $task)
    {
        $task->update(['phase_id' => null]);

        return response()->json(['message' => 'Fase removida exitosamente.']);
    }
}
