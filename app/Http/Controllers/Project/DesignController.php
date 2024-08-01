<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\DesignType;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DesignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($project_id)
    {
        Gate::authorize('viewAny', [Design::class, $project_id]);
        $project = Project::find($project_id);
        $designs = Design::where('project_id', $project_id)->with(['user', 'design_type'])->get();
        return inertia('User/Project/Design/Index')->with([
            'project' => $project,
            'designs' => $designs,
            'can' => [
                'create_design' => Auth::user()->can('create', [Design::class, $project_id]),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($project_id)
    {
        Gate::authorize('create', [Design::class, $project_id]);
        $project = Project::findOrFail($project_id);
        $design_types = DesignType::all();
        return inertia('User/Project/Design/Create')->with([
            'project' => $project,
            'design_types' => $design_types
        ]);
    }
}
