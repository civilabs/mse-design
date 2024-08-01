<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MemberPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, string $project_id): Response
    {
        $members = Member::where('project_id', $project_id)->pluck('user_id')->toArray();
        return in_array($user->id, $members)
            ? Response::allow()
            : Response::deny();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Member $member, string $project_id): Response
    {
        $members = Member::where('project_id', $project_id)->pluck('user_id')->toArray();
        return in_array($user->id, $members)
            ? Response::allow()
            : Response::deny();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, string $project_id): Response
    {
        $project = Project::findOrFail($project_id);
        return $user->id == $project->user_id
            ? Response::allow()
            : Response::deny();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Member $member, string $project_id): Response
    {
        $project = Project::findOrFail($project_id);
        return $user->id == $project->user_id || $user->id == $member->creator_id
            ? Response::allow()
            : Response::deny();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Member $member, string $project_id): Response
    {
        $project = Project::findOrFail($project_id);
        return ($project->user_id != $member->user_id) && ($user->id == $project->user_id || $user->id == $member->creator_id)
            ? Response::allow()
            : Response::deny();
    }
}
