<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Perpustakaan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-sm font-medium text-gray-500">Pengguna Aktif</h3>
                    <p class="text-xl font-bold text-gray-800 mt-1">{{ Auth::user()->name }}</p>
                    <span class="inline-block mt-2 px-3 py-1 text-xs font-semibold rounded-full {{ Auth::user()->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                        Role: {{ ucfirst(Auth::user()->role) }}
                    </span>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-sm font-medium text-gray-500">Total Koleksi Buku</h3>
                    <p class="text-3xl font-extrabold text-indigo-600 mt-1">{{ $totalBuku }}</p>
                    <p class="text-xs text-gray-400 mt-1">Buku terdaftar di MySQL</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 flex flex-col justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Kelola Data</h3>
                        <p class="text-xs text-gray-500 mt-1">Akses menu pengelolaan koleksi buku perpustakaan.</p>
                    </div>
                    <a href="{{ route('perpustakaan.index') }}" class="mt-4 inline-block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition duration-150">
                        Buka Data Buku &rarr;
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>