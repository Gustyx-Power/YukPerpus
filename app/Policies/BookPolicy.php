<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Semua user bisa melihat daftar buku
    }

    public function view(User $user, Book $book): bool
    {
        return true; // Semua user bisa melihat detail buku
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isPetugas(); // Hanya admin dan petugas yang bisa menambah buku
    }

    public function update(User $user, Book $book): bool
    {
        return $user->isAdmin() || $user->isPetugas(); // Hanya admin dan petugas yang bisa mengedit buku
    }

    public function delete(User $user, Book $book): bool
    {
        return $user->isAdmin(); // Hanya admin yang bisa menghapus buku
    }

    public function restore(User $user, Book $book): bool
    {
        return $user->isAdmin(); // Hanya admin yang bisa restore buku yang dihapus
    }

    public function forceDelete(User $user, Book $book): bool
    {
        return $user->isAdmin(); // Hanya admin yang bisa menghapus permanen buku
    }
} 