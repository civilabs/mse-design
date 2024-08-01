<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\Member;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DocumentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, $project_id): Response
    {
        $members = Member::where('project_id', $project_id)->pluck('user_id')->toArray();
        return in_array($user->id, $members)
            ? Response::allow()
            : Response::deny();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Document $document, string $project_id): Response
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
        $members = Member::where('project_id', $project_id)->pluck('user_id')->toArray();
        return in_array($user->id, $members)
            ? Response::allow()
            : Response::deny();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Document $document): Response
    {
        return $user->id == $document->user_id
            ? Response::allow()
            : Response::deny();
    }
}
