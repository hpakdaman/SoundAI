<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Firefly\FilamentBlog\Models\NewsLetter;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsLetterPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:NewsLetter');
    }

    public function view(AuthUser $authUser, NewsLetter $newsLetter): bool
    {
        return $authUser->can('View:NewsLetter');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:NewsLetter');
    }

    public function update(AuthUser $authUser, NewsLetter $newsLetter): bool
    {
        return $authUser->can('Update:NewsLetter');
    }

    public function delete(AuthUser $authUser, NewsLetter $newsLetter): bool
    {
        return $authUser->can('Delete:NewsLetter');
    }

    public function restore(AuthUser $authUser, NewsLetter $newsLetter): bool
    {
        return $authUser->can('Restore:NewsLetter');
    }

    public function forceDelete(AuthUser $authUser, NewsLetter $newsLetter): bool
    {
        return $authUser->can('ForceDelete:NewsLetter');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:NewsLetter');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:NewsLetter');
    }

    public function replicate(AuthUser $authUser, NewsLetter $newsLetter): bool
    {
        return $authUser->can('Replicate:NewsLetter');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:NewsLetter');
    }

}