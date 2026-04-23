<?php

namespace App\Policies;

use App\Models\Informasi;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InformasiPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Informasi $informasi): bool
    {
        // 1. Superadmin (Admin Kabupaten) bisa segalanya
        if ($user->isSuperAdmin()) {
            return true;
        }

        // 2. Admin OPD hanya bisa edit dokumen unitnya sendiri
        if ($user->isAdmin()) {
            return (string)$user->unit_id === (string)$informasi->unit_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Informasi $informasi): bool
    {
        // 1. Superadmin bisa segalanya
        if ($user->isSuperAdmin()) {
            return true;
        }

        // 2. Admin OPD hanya bisa hapus dokumen unitnya sendiri
        if ($user->isAdmin()) {
            return (string)$user->unit_id === (string)$informasi->unit_id;
        }

        return false;
    }

    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Informasi $informasi): bool { return true; }
    public function create(User $user): bool { return $user->isAdmin(); }
    public function restore(User $user, Informasi $informasi): bool { return $user->isSuperAdmin(); }
    public function forceDelete(User $user, Informasi $informasi): bool { return $user->isSuperAdmin(); }
}
