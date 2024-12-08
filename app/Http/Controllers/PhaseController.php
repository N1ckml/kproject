<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phase;
use App\Models\Project;
use Yajra\DataTables\Facades\DataTables;

class PhaseController extends Controller
{
    // Método para retornar la vista de fases
    public function index()
    {
        $projects = Project::all();  // Obtén todos los proyectos
        return view('fases.index', compact('projects'));  // Pasa la lista de proyectos a la vista
    }
    
    public function getData()
    {
        $phases = Phase::with('project')  // Incluimos el proyecto relacionado con la fase
            ->get()
            ->map(function ($phase) {
                return [
                    'id' => $phase->id,  // Incluimos el ID para el botón de editar
                    'project_name' => $phase->project->name,  // Nombre del proyecto
                    'name' => $phase->name,  // Nombre de la fase
                    'description' => $phase->description,  // Descripción de la fase
                    'actions' => '<div class="flex gap-2">
                        <button class="btn btn-edit" onclick="openPhaseModal(\'edit\', ' . $phase->id . ')">
                            Editar
                        </button>
                        <button class="btn btn-delete" onclick="deletePhase(' . $phase->id . ')">
                            Eliminar
                        </button>
                    </div>',
                ];
            });

        return datatables()->of($phases)->make(true);
    }

    // Método para almacenar una nueva fase
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id', // Validar que el ID de proyecto exista
        ]);

        $phase = Phase::create($request->all());

        return response()->json(['message' => 'Fase creada correctamente', 'phase' => $phase]);
    }

    // Método para mostrar los detalles de una fase
    public function show($id)
    {
        $phase = Phase::findOrFail($id);
        return response()->json($phase);
    }

    // Método para actualizar una fase existente
    public function update(Request $request, $id)
    {
        $phase = Phase::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id', // Validar que el ID de proyecto exista
        ]);

        $phase->update($request->all());

        return response()->json(['message' => 'Fase actualizada correctamente']);
    }

    // Método para eliminar una fase
    public function destroy($id)
    {
        $phase = Phase::findOrFail($id);
        $phase->delete();

        return response()->json(['message' => 'Fase eliminada correctamente']);
    }
}

