<?php

declare(strict_types=1);

namespace App\Policies\Music;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Music\Composition;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompositionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Composition');
    }

    public function view(AuthUser $authUser, Composition $composition): bool
    {
        return $authUser->can('View:Composition');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Composition');
    }

    public function update(AuthUser $authUser, Composition $composition): bool
    {
        return $authUser->can('Update:Composition');
    }

    public function delete(AuthUser $authUser, Composition $composition): bool
    {
        return $authUser->can('Delete:Composition');
    }

    public function restore(AuthUser $authUser, Composition $composition): bool
    {
        return $authUser->can('Restore:Composition');
    }

    public function forceDelete(AuthUser $authUser, Composition $composition): bool
    {
        return $authUser->can('ForceDelete:Composition');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Composition');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Composition');
    }

    public function replicate(AuthUser $authUser, Composition $composition): bool
    {
        return $authUser->can('Replicate:Composition');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Composition');
    }

}