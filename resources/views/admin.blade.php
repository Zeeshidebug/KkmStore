@extends('layout')

@section('content')
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<main class="max-w-5xl mx-auto py-10 px-6 text-white">
    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
    <div class="mb-4 p-3 bg-green-500 text-white rounded-md">
        {{ session('success') }}
    </div>
    @endif

    {{-- Form tambah produk --}}
    <form id="addForm" enctype="multipart/form-data" class="mb-8 bg-[#2a2727] p-6 rounded-lg">
        <div class="grid grid-cols-2 gap-4">
            <input type="text" name="name" placeholder="Nama Produk" class="p-2 rounded bg-[#1f1c1c] text-white" required>
            <input type="text" name="sku" placeholder="SKU" class="p-2 rounded bg-[#1f1c1c] text-white" required>
            <input type="number" name="price" placeholder="Harga" class="p-2 rounded bg-[#1f1c1c] text-white" required>
            <input type="file" name="image" accept=".jpg,.jpeg,.png" class="p-2 rounded bg-[#1f1c1c] text-white">
            
            <input type="text" name="sizes" placeholder="Ukuran (S, M, L)" class="p-2 rounded bg-[#1f1c1c] text-white">
            <input type="text" name="tags" placeholder="Tags" class="p-2 rounded bg-[#1f1c1c] text-white">
            <input type="number" name="stock" placeholder="Stok" class="p-2 rounded bg-[#1f1c1c] text-white" required>
            <input type="number" step="0.1" name="rating" placeholder="Rating (contoh: 4.5)" class="p-2 rounded bg-[#1f1c1c] text-white">
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
                    {{-- Tampilkan gambar --}}
                    <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->name }}" class="w-16 h-16 object-cover rounded">
                    @else
                    <span class="text-gray-400 text-sm">No Image</span>
                    @endif
                </td>
                <td class="p-2 border-b">{{ $p->name }}</td>
                <td class="p-2 border-b">{{ $p->sku }}</td>
                <td class="p-2 border-b">Rp{{ number_format($p->price) }}</td>
                <td class="p-2 border-b">{{ $p->stock }}</td>
                <td class="p-2 border-b text-center space-x-2">
                    
                    {{-- PERBAIKAN 1: Tombol Edit Pakai Class 'editBtn' & Data Attributes --}}
                    <button class="bg-blue-500 px-3 py-1 rounded hover:bg-blue-600 text-white editBtn"
                        data-id="{{ $p->id }}"
                        data-name="{{ $p->name }}"
                        data-sku="{{ $p->sku }}"
                        data-price="{{ $p->price }}"
                        data-stock="{{ $p->stock }}"
                        data-image="{{ $p->image }}">
                        Edit
                    </button>

                    {{-- PERBAIKAN 2: Tombol Hapus JANGAN dibungkus <form> --}}
                    <button class="bg-red-500 px-3 py-1 rounded hover:bg-red-600 deleteBtn" 
                        data-id="{{ $p->id }}">
                        Hapus
                    </button>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div id="editModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-xl w-full max-w-md text-black relative"> <button id="closeEditModalBtn" class="absolute top-3 right-3 text-gray-400 hover:text-black text-xl">✕</button>
            <h2 class="text-xl font-semibold mb-4">Edit Produk</h2>

            <form id="editForm" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit_id">

                <div class="mb-3">
                    <label class="block text-sm mb-1">Nama Produk</label>
                    <input type="text" id="edit_name" name="name" class="w-full px-3 py-2 rounded border border-gray-300" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm mb-1">SKU</label>
                    <input type="text" id="edit_sku" name="sku" class="w-full px-3 py-2 rounded border border-gray-300" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm mb-1">Harga</label>
                    <input type="number" id="edit_price" name="price" class="w-full px-3 py-2 rounded border border-gray-300" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm mb-1">Stok</label>
                    <input type="number" id="edit_stock" name="stock" class="w-full px-3 py-2 rounded border border-gray-300" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm mb-1">Gambar Baru (Opsional)</label>
                    <input type="file" name="image" accept="image/*">
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <button type="button" id="cancelEditBtn" class="px-4 py-2 bg-gray-500 rounded hover:bg-gray-600 text-white">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-black font-semibold rounded hover:bg-yellow-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('#addForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('admin.store') }}",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response.message);
                location.reload();
            },
            error: function(xhr) {
                alert('Gagal! Cek inputan.');
                console.log(xhr.responseText);
            }
        });
    });

    $('.editBtn').click(function() {
        let btn = $(this);

        $('#edit_id').val(btn.data('id'));
        $('#edit_name').val(btn.data('name'));
        $('#edit_sku').val(btn.data('sku'));
        $('#edit_price').val(btn.data('price'));
        $('#edit_stock').val(btn.data('stock'));

        $('#editModal').removeClass('hidden').addClass('flex');
    });

    $('#closeEditModalBtn, #cancelEditBtn').click(function() {
        $('#editModal').addClass('hidden').removeClass('flex');
    });

    $('#editForm').submit(function(e) {
        e.preventDefault();
        let id = $('#edit_id').val();
        let formData = new FormData(this);

        $.ajax({
            url: "/admin/update/" + id, 
            type: 'POST', 
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response.message);
                location.reload();
            },
            error: function(xhr) {
                alert('Gagal update!');
                console.log(xhr.responseText);
            }
        });
    });

    $('.deleteBtn').click(function() {
        let id = $(this).data('id');

        if(confirm('Yakin hapus?')) {
            $.ajax({
                url: "/admin/destroy/" + id,
                type: 'DELETE', 
                success: function(response) {
                    alert(response.message);
                    location.reload();
                },
                error: function(xhr) {
                    alert('Gagal hapus!');
                }
            });
        }
    });
    </script>

</main>
@endsection