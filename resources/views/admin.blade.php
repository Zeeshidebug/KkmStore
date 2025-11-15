@extends('layout')

@section('content')
<main class="max-w-5xl mx-auto py-10 px-6 text-white">
    <h1 class="text-2xl font-bold mb-6">Admin Dashboard — Produk</h1>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
    <div class="mb-4 p-3 bg-green-500 text-white rounded-md">
        {{ session('success') }}
    </div>
    @endif

    {{-- Form tambah produk --}}
    <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data" class="mb-8 bg-[#2a2727] p-6 rounded-lg">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <input type="text" name="name" placeholder="Nama Produk" class="p-2 rounded bg-[#1f1c1c] text-white" required>
            <input type="text" name="sku" placeholder="SKU" class="p-2 rounded bg-[#1f1c1c] text-white" required>
            <input type="number" name="price" placeholder="Harga" class="p-2 rounded bg-[#1f1c1c] text-white" required>
            <input type="file" name="image" accept=".jpg,.jpeg,.png" class="p-2 rounded bg-[#1f1c1c] text-white">
            <input type="text" name="sizes" placeholder="Ukuran (pisahkan dengan koma)" class="p-2 rounded bg-[#1f1c1c] text-white">
            <input type="text" name="tags" placeholder="Tag (pisahkan dengan koma)" class="p-2 rounded bg-[#1f1c1c] text-white">
            <input type="number" name="stock" placeholder="Stok" class="p-2 rounded bg-[#1f1c1c] text-white" required>
            <input type="number" step="0.1" name="rating" placeholder="Rating (0-5)" class="p-2 rounded bg-[#1f1c1c] text-white">
        </div>
        <textarea name="description" placeholder="Deskripsi produk" class="mt-4 w-full p-2 rounded bg-[#1f1c1c] text-white"></textarea>
        <button type="submit" class="mt-4 bg-yellow-400 text-black font-semibold px-6 py-2 rounded-md hover:bg-yellow-300">
            + Tambah Produk
        </button>
    </form>

    {{-- Tabel produk --}}
    <table class="w-full text-left text-white border-collapse">
        <thead>
            <tr class="bg-[#2a2727] text-yellow-400">
                <th class="p-2 border-b">Gambar</th>
                <th class="p-2 border-b">Nama</th>
                <th class="p-2 border-b">SKU</th>
                <th class="p-2 border-b">Harga</th>
                <th class="p-2 border-b">Stok</th>
                <th class="p-2 border-b text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
            <tr class="hover:bg-[#2a2727] transition">
                <td class="p-2 border-b">
                    @if($p->image)
                    <img src="{{ $p->image }}" alt="{{ $p->name }}" class="w-16 h-16 object-cover rounded">
                    @else
                    <span class="text-gray-400 text-sm">No Image</span>
                    @endif
                </td>
                <td class="p-2 border-b">{{ $p->name }}</td>
                <td class="p-2 border-b">{{ $p->sku }}</td>
                <td class="p-2 border-b">Rp{{ number_format($p->price) }}</td>
                <td class="p-2 border-b">{{ $p->stock }}</td>
                <td class="p-2 border-b text-center space-x-2">
                    {{-- Tombol Edit --}}
                    <button
                        class="bg-blue-500 px-3 py-1 rounded hover:bg-blue-600 text-white"
                        data-id="{{ $p->id }}"
                        data-name="{{ $p->name }}"
                        data-sku="{{ $p->sku }}"
                        data-price="{{ $p->price }}"
                        data-stock="{{ $p->stock }}"
                        data-image="{{ $p->image }}"
                        onclick="openEditModalFromButton(this)">
                        Edit
                    </button>



                    {{-- Tombol Hapus --}}
                    <form action="{{ route('admin.destroy', $p->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin ingin menghapus produk ini?')" class="bg-red-500 px-3 py-1 rounded hover:bg-red-600">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Edit Produk -->
    <div id="editModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
        <div class="bg-[#2a2727] p-6 rounded-xl w-full max-w-md text-white relative">
            <button onclick="closeEditModal()" class="absolute top-3 right-3 text-gray-400 hover:text-white text-xl">✕</button>
            <h2 class="text-xl font-semibold mb-4">Edit Produk</h2>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" id="edit_id">

                <div class="mb-3">
                    <label class="block text-sm mb-1">Nama Produk</label>
                    <input type="text" id="edit_name" name="name" class="w-full px-3 py-2 rounded bg-[#1f1c1c] border border-gray-600" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm mb-1">SKU</label>
                    <input type="text" id="edit_sku" name="sku" class="w-full px-3 py-2 rounded bg-[#1f1c1c] border border-gray-600" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm mb-1">Harga</label>
                    <input type="number" id="edit_price" name="price" class="w-full px-3 py-2 rounded bg-[#1f1c1c] border border-gray-600" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm mb-1">Stok</label>
                    <input type="number" id="edit_stock" name="stock" class="w-full px-3 py-2 rounded bg-[#1f1c1c] border border-gray-600" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm mb-1">Gambar Baru</label>
                    <input type="file" name="image" accept="image/*" class="text-white">
                    <img id="editPreview" class="mt-2 w-24 h-24 rounded object-cover hidden" />
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-500 rounded hover:bg-gray-600">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-black font-semibold rounded hover:bg-yellow-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModalFromButton(btn) {
            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const sku = btn.dataset.sku;
            const price = btn.dataset.price;
            const stock = btn.dataset.stock;
            const image = btn.dataset.image;

            openEditModal(id, name, sku, price, stock, image);
        }

        function openEditModal(id, name, sku, price, stock, image) {
            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_sku').value = sku;
            document.getElementById('edit_price').value = price;
            document.getElementById('edit_stock').value = stock;

            // Preview gambar
            const preview = document.getElementById('editPreview');
            if (image && image !== 'null') {
                preview.src = image;
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }

            // Atur action form-nya agar sesuai dengan ID produk
            document.getElementById('editForm').action = `/admin/${id}`;
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

</main>
@endsection