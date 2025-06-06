<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ListController extends Controller
{
    public function show(Project $project)
    {
        $project->load([
            'columns' => fn($q) => $q->orderBy('order'),
            'collaborateurs',
            'columns.tasks' => fn($q) => $q->orderBy('created_at'),
            'columns.tasks.collaborateurs',
            'columns.tasks.creator',
        ]);

        return view('pages.project.list', compact('project'));
    }
}
