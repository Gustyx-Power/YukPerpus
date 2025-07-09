<x-filament-panels::page>
    <h2>Daftar Buku</h2>
    @livewire('books-table')
    <x-filament::button wire:click="exportBooksPdf">
        Export Buku PDF
    </x-filament::button>

    <h2>Daftar Peminjaman</h2>
    @livewire('loans-table')
    <x-filament::button wire:click="exportLoansPdf">
        Export Peminjaman PDF
    </x-filament::button>

    <h2>Daftar Pengguna</h2>
    @livewire('users-table')
    <x-filament::button wire:click="exportUsersPdf">
        Export Pengguna PDF
    </x-filament::button>
</x-filament-panels::page>