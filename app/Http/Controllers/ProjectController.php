<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Project;
use App\Models\User;
use App\Service\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', Auth::id())->get();
        return inertia('User/Project/Index')->with([
            'projects' => $projects
        ]);
    }

    public function create()
    {
        return inertia('User/Project/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'string|required',
            'location' => 'string|nullable',
            'latitude' => 'numeric|required',
            'longitude' => 'numeric|required',
            'image' => 'nullable|image|max:10240',
            'description' => 'nullable',
        ]);

        $project = new Project($validated);
        $project->user_id = Auth::id();
        if ($request->hasFile('image')) {
            $image_name_to_save = ImageUploadService::upload_project_image($request->file('image'));
            $project->image = $image_name_to_save;
        }
        $project->save();

        $member = new Member();
        $member->project_id = $project->id;
        $member->user_id = Auth::id();
        $member->creator_id = Auth::id();
        $member->member_role_id = 1;
        $member->save();

        return redirect(route('user.projects.index'));
    }

    public function edit(string $id)
    {
        $project = Project::findOrFail($id);
        Gate::authorize('update', $project);

        $cord = [$project->longitude, $project->latitude];
        return inertia('User/Project/Edit')->with([
            'project' => $project,
            'cord' => $cord,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);
        Gate::authorize('update', $project);

        $validated = $request->validate([
            'name' => 'string|required',
            'location' => 'string|nullable',
            'latitude' => 'numeric|required',
            'longitude' => 'numeric|required',
            'description' => 'nullable',
        ]);
        $request->validate([
            'image' => 'nullable|image|max:10240'
        ]);

        $project->fill($validated);
        if ($request->hasFile('image')) {
            $image_name_to_save = ImageUploadService::upload_project_image($request->file('image'));
            Storage::delete('public/project/image/' . $project->image);
            $project->image = $image_name_to_save;
        }
        $project->update();

        return redirect(route('user.projects.index'));
    }

    public function map()
    {
        $projects = Auth::user()->projects;
        return inertia('User/Project/Map')->with([
            'projects' => $projects
        ]);
    }

    public function dashboard($id)
    {
        $project = Project::findOrFail($id);
        Gate::authorize('view', $project);

        $cord = [$project->longitude, $project->latitude];
        return inertia('User/Project/Dashboard')->with([
            'project' => $project,
            'cord' => $cord,
            'can' => [
                'edit_project' => Auth::user()->can('update', $project),
            ],
        ]);
    }

    public function show_delete(string $id)
    {
        $project = Project::findOrFail($id);
        Gate::authorize('delete', $project);

        return inertia('User/Project/Delete')->with([
            'project' => $project
        ]);
    }

    public function destroy(Request $request, string $id)
    {
        $project = Project::findOrFail($id);
        Gate::authorize('delete', $project);

        $this->validate($request, [
            'email' => 'required|email'
        ]);

        if (Auth::user()->email == $request->email) {
            $other_users = $project->users()->where('user_id', '!=', $project->user_id)->get();
            $designs = $project->designs;
            $documents = $project->documents;
            if ($other_users->isEmpty() && $designs->isEmpty() && $documents->isEmpty()) {
                $image_url = $project->image;
                $project->users()->where('user_id', $project->user_id)->detach();
                $project->delete();
                Storage::delete('public/project/image/' . $image_url);
                return redirect(route('user.projects.index'))->with('success', 'Project deleted successfully');
            } else {
                return back()->with('error', 'DELETION ERROR: Please ensure that all project members, designs, and documents associated with this project have been deleted before attempting to delete the project.');
            }
        } else {
            return back()->with('error', 'The confirmation email you entered is not correct.');
        }
    }
}
