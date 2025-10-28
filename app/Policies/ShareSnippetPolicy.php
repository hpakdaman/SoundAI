<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Firefly\FilamentBlog\Models\ShareSnippet;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShareSnippetPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ShareSnippet');
    }

    public function view(AuthUser $authUser, ShareSnippet $shareSnippet): bool
    {
        return $authUser->can('View:ShareSnippet');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ShareSnippet');
    }

    public function update(AuthUser $authUser, ShareSnippet $shareSnippet): bool
    {
        return $authUser->can('Update:ShareSnippet');
    }

    public function delete(AuthUser $authUser, ShareSnippet $shareSnippet): bool
    {
        return $authUser->can('Delete:ShareSnippet');
    }

    public function restore(AuthUser $authUser, ShareSnippet $shareSnippet): bool
    {
        return $authUser->can('Restore:ShareSnippet');
    }

    public function forceDelete(AuthUser $authUser, ShareSnippet $shareSnippet): bool
    {
        return $authUser->can('ForceDelete:ShareSnippet');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ShareSnippet');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ShareSnippet');
    }

    public function replicate(AuthUser $authUser, ShareSnippet $shareSnippet): bool
    {
        return $authUser->can('Replicate:ShareSnippet');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ShareSnippet');
    }

}