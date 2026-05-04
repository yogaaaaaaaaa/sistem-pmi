<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Penempatan;

class PenempatanPolicy
{
    /*
    |------------------------------------
    | Semua admin boleh lihat
    |------------------------------------
    */
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Penempatan $penempatan)
    {
        return true;
    }

    /*
    |------------------------------------
    | EDIT hanya wilayah sendiri
    |------------------------------------
    */
    public function update(User $user, Penempatan $penempatan)
    {
        return $user->wilayah === $penempatan->wilayah;
    }

    /*
    |------------------------------------
    | DELETE hanya wilayah sendiri
    |------------------------------------
    */
    public function delete(User $user, Penempatan $penempatan)
    {
        return $user->wilayah === $penempatan->wilayah;
    }

    /*
    |------------------------------------
    | CREATE boleh semua admin
    |------------------------------------
    */
    public function create(User $user)
    {
        return true;
    }
}