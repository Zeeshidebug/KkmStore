@extends('layout')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-white">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    {{-- Bagian gambar produk --}}
    <div>
      <div class="rounded-2xl overflow-hidden bg-[#1f1c1c] shadow">
        <img src="{{ asset('storage/' . $product->image) }}"
          alt="{{ $product->name }}"
          class="w-full h-96 object-cover" id="mainImage">
      </div>
    </div>

    {{-- Bagian detail --}}
    <div>
      <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
        <div class="flex gap-2">
          <a href="{{ route('home') }}"
            class="px-3 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-600">
            ← Kembali
          </a>
          <button id="openCartBtn"
            class="px-3 py-2 bg-yellow-400 text-black rounded-md hover:bg-yellow-300">
            🛒
          </button>
        </div>
      </div>

      <p class="text-sm text-gray-400 mb-2">SKU: <span class="font-mono">{{ $product->sku }}</span></p>
      <p class="text-yellow-400 text-2xl font-extrabold mb-3">Rp{{ number_format($product->price) }}</p>
      <p class="text-gray-300 mb-4">{{ $product->description }}</p>

      <div class="flex items-center gap-4 mb-6">
        <span>⭐ {{ number_format($product->rating, 1) ?? '0.0' }}</span>
        <span class="text-sm text-gray-400">Stok: {{ $product->stock }}</span>
      </div>

      {{-- Ukuran (jika ada) --}}
      @if($product->sizes)
      <div class="mb-6">
        <label class="block text-sm mb-2 text-gray-300">Pilih ukuran</label>
        <div class="flex gap-2">
          @foreach(explode(',', $product->sizes) as $size)
          <button class="size-btn px-3 py-2 border rounded-md text-sm text-white hover:bg-indigo-600 hover:text-white"
            data-size="{{ trim($size) }}">{{ trim($size) }}</button>
          @endforeach
        </div>
      </div>
      @endif

      <button id="addToCartBtn"
        data-id="{{ $product->id }}"
        data-name="{{ $product->name }}"
        data-price="{{ $product->price }}"
        data-image="{{ $product->image }}"
        class="inline-flex items-center gap-2 px-5 py-2 bg-yellow-400 text-black rounded-md font-semibold hover:opacity-90">
        Add to Cart
      </button>
    </div>
  </div>
</main>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const addBtn = document.getElementById('addToCartBtn');
    if (!addBtn) return;

    addBtn.addEventListener('click', () => {
      const product = {
        id: addBtn.dataset.id,
        name: addBtn.dataset.name,
        price: parseInt(addBtn.dataset.price),
        image: addBtn.dataset.image,
        qty: 1
      };

      const cart = JSON.parse(localStorage.getItem('kkm_cart') || '[]');
      const existing = cart.find(p => p.id === product.id);

      if (existing) {
        existing.qty += 1;
      } else {
        cart.push(product);
      }

      localStorage.setItem('kkm_cart', JSON.stringify(cart));
      alert('✅ Produk ditambahkan ke keranjang!');
      if (typeof renderCart === 'function') renderCart();
      if (typeof updateCartCount === 'function') updateCartCount();
    });

    // Tombol pilih ukuran (efek visual aja)
    document.querySelectorAll('.size-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('bg-indigo-600', 'text-white'));
        btn.classList.add('bg-indigo-600', 'text-white');
      });
    });
  });
</script>
@endsection