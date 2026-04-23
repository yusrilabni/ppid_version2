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
        return $user->role === 'admin' || $user->role === 'superadmin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Informasi $informasi): bool
    {
        if ($user->role === 'superadmin') {
            return true;
        }

        if ($user->role !== 'admin') {
            return false;
        }

        // Jika unit_id user kosong, coba sinkronkan dulu (seperti di Controller)
        $userUnitId = $user->unit_id;
        if (!$userUnitId && $user->nip) {
            $apiData = \App\Models\User::getDataFromApi($user->nip);
            if ($apiData && isset($apiData['unit_id'])) {
                $userUnitId = $apiData['unit_id'];
            }
        }

        return $userUnitId == $informasi->unit_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Informasi $informasi): bool
    {
        if ($user->role === 'superadmin') {
            return true;
        }

        if ($user->role !== 'admin') {
            return false;
        }

        $userUnitId = $user->unit_id;
        if (!$userUnitId && $user->nip) {
            $apiData = \App\Models\User::getDataFromApi($user->nip);
            if ($apiData && isset($apiData['unit_id'])) {
                $userUnitId = $apiData['unit_id'];
            }
        }

        return $userUnitId == $informasi->unit_id;
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
