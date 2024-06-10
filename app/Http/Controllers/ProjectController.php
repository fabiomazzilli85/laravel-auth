<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'web-site' => 'required|url',
            'slug' => 'required|string|unique:projects,slug',
            'description' => 'required|string',
        ]);

        // Nuovo progetto.
        $project = new Project();
        $project->name = $request->name;
        $project->description = $request->description; 
        $project->web_site = $request->input('web-site'); 
        $project->slug = $request->slug;
        $project->user_id = auth()->user()->id;
        $project->save();

        // Vengo reindirizzato a projects.index. Messaggio: 'Progetto Creato'.
        return redirect()->route('projects.index')->with('success', 'Progetto creato.');
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'web-site' => 'nullable|url',
            'slug' => 'required|string|unique:projects,slug,' . $project->id,
            'description' => 'required|string',
        ]);

        // Qui invece lo aggiorno. 
        $project->name = $request->name;
        $project->web_site = $request->input('web-site'); // Campo web-site
        $project->slug = $request->slug;
        $project->description = $request->description;
        $project->save();

        // Vengo reindirizzato. Compare un altro messaggio.  
        return redirect()->route('projects.index')->with('success', 'Progetto aggiornato.');
    }

    public function destroy(Project $project)
{
    // L'utente è loggato?
    if (auth()->user()->id !== $project->user_id) {
        return abort(403); // Accesso negato
    }
    
    // Elimina il progetto
    $project->delete();

    // Reindirizzamento con terzo messaggio.
    return redirect()->route('projects.index')->with('success', 'Progetto eliminato.');
}
}
