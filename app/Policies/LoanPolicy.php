<?php

namespace App\Policies;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LoanPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Semua user bisa melihat daftar peminjaman
    }

    public function view(User $user, Loan $loan): bool
    {
        // User hanya bisa melihat peminjaman mereka sendiri
        // Admin dan petugas bisa melihat semua peminjaman
        return $user->isAdmin() || $user->isPetugas() || $user->id === $loan->user_id;
    }

    public function create(User $user): bool
    {
        return true; // Semua user bisa membuat peminjaman
    }

    public function update(User $user, Loan $loan): bool
    {
        // Hanya admin dan petugas yang bisa mengubah status peminjaman
        return $user->isAdmin() || $user->isPetugas();
    }

    public function delete(User $user, Loan $loan): bool
    {
        return $user->isAdmin(); // Hanya admin yang bisa menghapus peminjaman
    }

    public function restore(User $user, Loan $loan): bool
    {
        return $user->isAdmin(); // Hanya admin yang bisa restore peminjaman yang dihapus
    }

    public function forceDelete(User $user, Loan $loan): bool
    {
        return $user->isAdmin(); // Hanya admin yang bisa menghapus permanen peminjaman
    }
} 