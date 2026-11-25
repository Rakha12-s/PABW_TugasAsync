<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Data Buku Perpustakaan
        </h2>
    </x-slot>

    <style>
        .custom-table-row:hover {
            background-color: #f8fafc !important;
            transition: background-color 0.2s ease-in-out;
        }

        .custom-modal-backdrop {
            background-color: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(3px);
        }

        .custom-badge-stok {
            border-width: 1px;
            font-size: 0.725rem;
            font-weight: 600;
            letter-spacing: 0.025em;
        }

        .custom-alert-box {
            border-left-width: 5px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .custom-search-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            border-color: #6366f1;
        }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div id="alert-container" class="hidden p-4 rounded-md custom-alert-box flex justify-between items-center transition-all duration-300">
                <span id="alert-message" class="text-sm font-medium"></span>
                <button onclick="document.getElementById('alert-container').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 font-bold">&times;</button>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="w-full md:w-1/3">
                    <input type="text" id="searchInput" onkeyup="filterBuku()" placeholder="Cari kode, judul, atau penulis..." class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm custom-search-input">
                </div>
                <div>
                    <button onclick="openModal('add')" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-md text-sm transition">
                        + Tambah Buku Baru
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600" id="bukuTable">
                    <thead class="bg-gray-50 text-gray-700 font-semibold border-b border-gray-200 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Kode Buku</th>
                            <th class="px-4 py-3">Judul Buku</th>
                            <th class="px-4 py-3">Penulis</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Stok</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="bukuTableBody" class="divide-y divide-gray-200">
                        @forelse($buku as $index => $item)
                        <tr class="custom-table-row" id="row-{{ $item->id }}">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-900">{{ $item->kode_buku }}</td>
                            <td class="px-4 py-3 font-medium text-indigo-950">{{ $item->judul }}</td>
                            <td class="px-4 py-3">{{ $item->penulis }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-700 border border-gray-200 text-xs">{{ $item->kategori }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 rounded-full custom-badge-stok {{ $item->stok > 0 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                                    {{ $item->stok }} unit
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center space-x-2">
                                @if(auth()->user()?->role === 'admin')
                                    <button onclick="editBuku('{{ $item->id }}')" class="bg-amber-500 hover:bg-amber-600 text-white text-xs px-3 py-1 rounded transition">Edit</button>
                                    <button onclick="deleteBuku('{{ $item->id }}')" class="bg-rose-600 hover:bg-rose-700 text-white text-xs px-3 py-1 rounded transition">Hapus</button>
                                @else
                                    <span class="text-xs text-gray-400 italic">Hanya Melihat</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr id="emptyRow">
                            <td colspan="7" class="px-4 py-8 text-center text-gray-400">Belum ada data buku tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div id="bukuModal" class="fixed inset-0 hidden custom-modal-backdrop flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                <h3 id="modalTitle" class="font-bold text-gray-800 text-lg">Tambah Buku Baru</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>
            
            <form id="bukuForm" onsubmit="handleFormSubmit(event)" class="p-6 space-y-4">
                <input type="hidden" id="buku_id" name="buku_id">

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Kode Buku</label>
                    <input type="text" id="kode_buku" name="kode_buku" placeholder="Contoh: BK-011" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:border-indigo-500">
                    <span id="error-kode_buku" class="text-xs text-red-500 mt-1 block"></span>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Judul Buku</label>
                    <input type="text" id="judul" name="judul" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:border-indigo-500">
                    <span id="error-judul" class="text-xs text-red-500 mt-1 block"></span>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Penulis</label>
                    <input type="text" id="penulis" name="penulis" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:border-indigo-500">
                    <span id="error-penulis" class="text-xs text-red-500 mt-1 block"></span>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Kategori</label>
                        <input type="text" id="kategori" name="kategori" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:border-indigo-500">
                        <span id="error-kategori" class="text-xs text-red-500 mt-1 block"></span>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Stok</label>
                        <input type="number" id="stok" name="stok" min="0" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:border-indigo-500">
                        <span id="error-stok" class="text-xs text-red-500 mt-1 block"></span>
                    </div>
                </div>

                <div class="flex justify-end space-x-2 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded hover:bg-gray-300 transition">Batal</button>
                    <button type="submit" id="btnSubmit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded hover:bg-indigo-700 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const csrfToken = '{{ csrf_token() }}';

        function openModal(mode) {
            clearErrors();
            document.getElementById('bukuForm').reset();
            document.getElementById('buku_id').value = '';
            
            if (mode === 'add') {
                document.getElementById('modalTitle').innerText = 'Tambah Buku Baru';
            }
            document.getElementById('bukuModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('bukuModal').classList.add('hidden');
        }

        function clearErrors() {
            ['kode_buku', 'judul', 'penulis', 'kategori', 'stok'].forEach(field => {
                const errElem = document.getElementById(`error-${field}`);
                if (errElem) errElem.innerText = '';
            });
        }

        function showAlert(message, isSuccess = true) {
            const container = document.getElementById('alert-container');
            const msg = document.getElementById('alert-message');
            msg.innerText = message;
            
            if (isSuccess) {
                container.className = 'p-4 rounded-md custom-alert-box flex justify-between items-center bg-emerald-50 text-emerald-900 border-emerald-500';
            } else {
                container.className = 'p-4 rounded-md custom-alert-box flex justify-between items-center bg-rose-50 text-rose-900 border-rose-500';
            }
            
            container.classList.remove('hidden');
            setTimeout(() => container.classList.add('hidden'), 4000);
        }

        function handleFormSubmit(event) {
            event.preventDefault();
            clearErrors();

            const id = document.getElementById('buku_id').value;
            const isEdit = id !== '';
            const url = isEdit ? `/perpustakaan/buku/${id}` : '/perpustakaan/buku';
            
            const payload = {
                kode_buku: document.getElementById('kode_buku').value,
                judul: document.getElementById('judul').value,
                penulis: document.getElementById('penulis').value,
                kategori: document.getElementById('kategori').value,
                stok: document.getElementById('stok').value,
            };

            fetch(url, {
                method: isEdit ? 'PUT' : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(async response => {
                const data = await response.json();
                
                if (!response.ok) {
                    if (response.status === 422 && data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            const errElem = document.getElementById(`error-${key}`);
                            if (errElem) errElem.innerText = data.errors[key][0];
                        });
                    } else {
                        showAlert(data.message || 'Terjadi kesalahan sistem.', false);
                    }
                    return;
                }

                showAlert(data.message, true);
                closeModal();
                setTimeout(() => location.reload(), 800);
            })
            .catch(() => showAlert('Gagal menghubungkan ke server.', false));
        }

        function editBuku(id) {
            openModal('edit');
            document.getElementById('modalTitle').innerText = 'Edit Data Buku';

            fetch(`/perpustakaan/buku/${id}/edit`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('buku_id').value = data.id;
                document.getElementById('kode_buku').value = data.kode_buku;
                document.getElementById('judul').value = data.judul;
                document.getElementById('penulis').value = data.penulis;
                document.getElementById('kategori').value = data.kategori;
                document.getElementById('stok').value = data.stok;
            })
            .catch(() => showAlert('Gagal mengambil data buku.', false));
        }

        function deleteBuku(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus data buku ini?')) return;

            fetch(`/perpustakaan/buku/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, true);
                    const row = document.getElementById(`row-${id}`);
                    if (row) row.remove();
                } else {
                    showAlert(data.message, false);
                }
            })
            .catch(() => showAlert('Gagal menghapus data.', false));
        }

        function filterBuku() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#bukuTableBody tr:not(#emptyRow)');
            
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        }
    </script>
</x-app-layout>