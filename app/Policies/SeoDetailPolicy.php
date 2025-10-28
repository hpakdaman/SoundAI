<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Firefly\FilamentBlog\Models\SeoDetail;
use Illuminate\Auth\Access\HandlesAuthorization;

class SeoDetailPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SeoDetail');
    }

    public function view(AuthUser $authUser, SeoDetail $seoDetail): bool
    {
        return $authUser->can('View:SeoDetail');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SeoDetail');
    }

    public function update(AuthUser $authUser, SeoDetail $seoDetail): bool
    {
        return $authUser->can('Update:SeoDetail');
    }

    public function delete(AuthUser $authUser, SeoDetail $seoDetail): bool
    {
        return $authUser->can('Delete:SeoDetail');
    }

    public function restore(AuthUser $authUser, SeoDetail $seoDetail): bool
    {
        return $authUser->can('Restore:SeoDetail');
    }

    public function forceDelete(AuthUser $authUser, SeoDetail $seoDetail): bool
    {
        return $authUser->can('ForceDelete:SeoDetail');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:SeoDetail');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:SeoDetail');
    }

    public function replicate(AuthUser $authUser, SeoDetail $seoDetail): bool
    {
        return $authUser->can('Replicate:SeoDetail');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:SeoDetail');
    }

}