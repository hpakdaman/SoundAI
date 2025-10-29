<?php

declare(strict_types=1);

namespace App\Policies\Music;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Music\Vibe;
use Illuminate\Auth\Access\HandlesAuthorization;

class VibePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Vibe');
    }

    public function view(AuthUser $authUser, Vibe $vibe): bool
    {
        return $authUser->can('View:Vibe');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Vibe');
    }

    public function update(AuthUser $authUser, Vibe $vibe): bool
    {
        return $authUser->can('Update:Vibe');
    }

    public function delete(AuthUser $authUser, Vibe $vibe): bool
    {
        return $authUser->can('Delete:Vibe');
    }

    public function restore(AuthUser $authUser, Vibe $vibe): bool
    {
        return $authUser->can('Restore:Vibe');
    }

    public function forceDelete(AuthUser $authUser, Vibe $vibe): bool
    {
        return $authUser->can('ForceDelete:Vibe');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Vibe');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Vibe');
    }

    public function replicate(AuthUser $authUser, Vibe $vibe): bool
    {
        return $authUser->can('Replicate:Vibe');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Vibe');
    }

}