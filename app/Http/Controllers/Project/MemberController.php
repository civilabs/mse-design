<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberRole;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($project_id)
    {
        Gate::authorize('viewAny', [Member::class, $project_id]);
        $project = Project::find($project_id);
        $members = Member::where('project_id', $project_id)->with(['user', 'member_role'])->get();
        return inertia('User/Project/Member/Index')->with([
            'project' => $project,
            'members' => $members,
            'can' => [
                'create_member' => Auth::user()->can('create', [Member::class, $project_id]),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($project_id)
    {
        Gate::authorize('create', [Member::class, $project_id]);
        $project = Project::find($project_id);
        $member_roles = MemberRole::all();
        return inertia('User/Project/Member/Create')->with([
            'project' => $project,
            'member_roles' => $member_roles,
        ]);
    }

    /**
     * Search a member with a given email.
     */
    public function search(Request $request, $project_id)
    {
        Gate::authorize('create', [Member::class, $project_id]);
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        session()->put('email', $request->email);

        return redirect(route('user.projects.members.get_search', $project_id));
    }

    /**
     * Get a search result for a member with a given email.
     */
    public function get_search($project_id)
    {
        Gate::authorize('create', [Member::class, $project_id]);
        $email = session()->get('email');

        $project = Project::find($project_id);
        $member_roles = MemberRole::all();
        $user = User::where('email', $email)->first();
        return inertia('User/Project/Member/Create')->with([
            'project' => $project,
            'member_roles' => $member_roles,
            'user' => $user,
            'email' => $email
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $project_id)
    {
        Gate::authorize('create', [Member::class, $project_id]);
        $validated = $request->validate([
            'user_id' => 'integer|required',
            'member_role_id' => 'integer|required',
        ]);
        $mem = Member::where(['project_id' => $project_id, 'user_id' => $request->user_id])->first();
        if (!$mem) {
            $member = new Member($validated);
            $member->project_id = $project_id;
            $member->creator_id = Auth::id();
            $member->save();
            return redirect(route('user.projects.members.index', $project_id))->with('success', 'Member added successfully');
        } else {
            return redirect(route('user.projects.members.index', $project_id))->with('error', 'Member already added by ' . $mem->creator->name);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $project_id, string $member_id)
    {
        $project = Project::findOrFail($project_id);
        $member = Member::with(['user', 'member_role'])->findOrFail($member_id);
        $member_roles = MemberRole::all();
        return inertia('User/Project/Member/Show')->with([
            'project' => $project,
            'member' => $member,
            'member_roles' => $member_roles,
            'can' => [
                'edit_member' => Auth::user()->can('update', [$member, $project_id]),
                'delete_member' => Auth::user()->can('delete', [$member, $project_id]),
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $project_id, string $member_id)
    {
        $member = Member::findOrFail($member_id);
        Gate::authorize('update', [$member, $project_id]);
        $request->validate([
            'member_role_id' => 'integer|required',
        ]);
        $member->member_role_id = $request->member_role_id;
        $member->update();
        return redirect(route('user.projects.members.show', [$project_id, $member_id]))->with('success', 'Member role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $project_id, string $member_id)
    {
        $member = Member::findOrFail($member_id);
        Gate::authorize('delete', [$member, $project_id]);
        $member->delete();
        return redirect(route('user.projects.members.index', $project_id))->with('success', 'Member deleted successfully');
    }
}
