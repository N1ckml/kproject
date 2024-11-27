<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    //
    public function index()
    {
        return view('proyectos.index');
    }

    public function getData()
    {
        $projects = Project::select(['id', 'name', 'description', 'created_at']);
        return DataTables::of($projects)
            ->addColumn('actions', function ($project) {
                return '
                    <div class="flex gap-2">
                        <button class="btn-edit" onclick="openModal(\'edit\', ' . $project->id . ')">Editar</button>
                        <button class="btn-delete" onclick="deleteProject(' . $project->id . ')">Eliminar</button>
                    </div>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project = Project::create($request->all());

        return response()->json(['message' => 'Proyecto creado correctamente', 'project' => $project]);
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->update($request->all());

        return response()->json(['message' => 'Proyecto actualizado correctamente']);
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json(['message' => 'Proyecto eliminado correctamente']);
    }
}
