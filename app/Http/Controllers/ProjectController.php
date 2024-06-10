<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'web-site' => 'required|url',
            'slug' => 'required|string|unique:projects,slug',
        ]);

        // Nuovo progetto.
        $project = new Project();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->name = $request->name; // Manca l'input per il campo name
        $project->web_site = $request->input('web-site'); // Campo web-site
        $project->slug = $request->slug;
        $project->user_id = auth()->user()->id;
        $project->save();

        // Vengo reindirizzato a projects.index. Messaggio: 'Progetto Creato'.
        return redirect()->route('projects.index')->with('success', 'Progetto creato.');
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'name' => 'required|string|max:255',
            'web-site' => 'nullable|url',
            'slug' => 'required|string|unique:projects,slug,' . $project->id, // Assicura che lo slug sia univoco, escludendo l'ID del progetto corrente
        ]);

        // Qui invece lo aggiorno. 
        $project->title = $request->title;
        $project->description = $request->description;
        $project->name = $request->name;
        $project->web_site = $request->input('web-site'); // Campo web-site
        $project->slug = $request->slug;
        $project->save();

        // Vengo reindirizzato. Compare un altro messaggio.  
        return redirect()->route('projects.index')->with('success', 'Progetto aggiornato.');
    }
}
