<?php

namespace App\Policies;

use App\Models\Informasi;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InformasiPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user !== null; // Allow any authenticated user to view the list
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Informasi $informasi): bool
    {
        return $user !== null; // Allow any authenticated user to view a single item
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Informasi $informasi): bool
    {
        // Superadmin punya akses penuh
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Selain Admin tidak punya akses
        if (!$user->isAdmin()) {
            return false;
        }

        // BYPASS TOTAL UNTUK DEBUGGING 403 (Sesuai keinginan user agar admin lancar)
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Informasi $informasi): bool
    {
        if ($user->role === 'superadmin' || $user->role === 'admin') {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Informasi $informasi): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Informasi $informasi): bool
    {
        return false;
    }
}
