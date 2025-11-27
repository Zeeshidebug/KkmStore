@extends('layout')

@section('content')

<main>
    <section class="relative h-[450px] md:h-[550px] overflow-hidden">

        <!-- Wrapper slider -->
        <div class="absolute inset-0 overflow-hidden">
            <div id="heroSlider" class="flex w-full h-full transition-transform duration-700 ease-in-out">
                <img src="/assets/furina6.jpg" class="w-full h-full object-cover flex-shrink-0">
                <img src="/assets/wood.jpg" class="w-full h-full object-cover flex-shrink-0">
                <img src="/assets/tachon.jpg" class="w-full h-full object-cover flex-shrink-0">
                <img src="/assets/backroundhoror.jpg" class="w-full h-full object-cover flex-shrink-0">
            </div>
        </div>

        <!-- Overlay gelap -->
        <div class="absolute inset-0 bg-black/40"></div>

        <!-- HERO content tetap sama -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
            <div class="max-w-2xl text-white">
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight">Store Resmi Tim Esports KKM</h1>
                <p class="mt-4 text-lg opacity-90">Merch resmi — kaos, hoodie, topi, dan barang koleksi. Dukunganmu membantu tim terus berkembang!</p>
                <div class="mt-6 flex gap-3">
                    <a href="#products" class="px-4 py-2 bg-yellow-400 text-black font-semibold rounded-md shadow">Jelajahi Merch</a>
                    <a href="#about" class="px-4 py-2 bg-yellow-400 text-black font-semibold rounded-md shadow">Tentang KKM</a>
                </div>
            </div>
        </div>

        <!-- Tombol prev -->
        <button id="prevSlide"
            class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/40 p-3 rounded-full text-white text-2xl">
            ‹
        </button>

        <!-- Tombol next -->
        <button id="nextSlide"
            class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/40 p-3 rounded-full text-white text-2xl">
            ›
        </button>

    </section>


    <!-- PRODUCTS -->
    <section id="products" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Produk dari database --}}
        <div id="productsGrid" class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $p)
            <div class="bg-[#2a2727] rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->name }}" class="w-full h-56 object-cover">
                <div class="p-4 text-white">
                    <h3 class="font-semibold">{{ $p->name }}</h3>
                    <p class="text-yellow-400 font-bold mt-1">Rp{{ number_format($p->price) }}</p>
                    <div class="mt-3 flex gap-2">
                        <a href="{{ route('product.show', $p->id) }}"
                            class="flex-1 text-center py-2 bg-yellow-400 text-black rounded-md font-semibold hover:opacity-90">
                            Buy
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div id="noResults" class="mt-8 text-center text-gray-500 hidden">Tidak ada produk yang cocok.</div>
    </section>


    <!-- ABOUT -->
    <section id="about" class="bg-[#1f1c1c]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h3 class="text-xl font-semibold text-gray-300">Tentang KKM</h3>
            <p class="mt-3 text-gray-300">
                KKM adalah tim esports yang ... gacor di berbagai turnamen nasional dan internasional. Kami berkomitmen untuk
                memberikan yang terbaik bagi komunitas kami, dan merchandise resmi ini adalah cara kami untuk terhubung dengan
                para penggemar serta mendukung perjalanan kami. Dukung kami dengan mengenakan merch resmi KKM dan tunjukkan
                semangatmu!
            </p>
        </div>
    </section>

    <!-- CONTACT -->
    <section id="contact" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h3 class="text-lg font-semibold text-gray-300">Hubungi Kami</h3>
        <p class="mt-2 text-sm text-gray-300">
            Untuk bulk order, kerjasama sponsor, atau pertanyaan produk — hubungi: <a href="mailto:merch@kkm-esports.example" class="text-indigo-400 hover:underline">merch@kkm-esports.example</a>
        </p>
    </section>
</main>

<footer class="border-t bg-[#1f1c1c]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-sm text-white flex items-center justify-between">
        <div>© <span id="year"></span> KKM Esports — All rights reserved.</div>
        <div class="hidden sm:block">Built with ❤️ — Kukusan Merdeka</div>
    </div>
</footer>

{{-- CART DRAWER --}}
<div id="cartDrawer" class="fixed inset-0 z-50 pointer-events-none">
    <div id="cartBackdrop" class="absolute inset-0 bg-black/40 opacity-0 transition-opacity"></div>
    <aside id="cartPanel" class="absolute right-0 top-0 h-full w-full sm:w-96 bg-white shadow-xl transform translate-x-full transition-transform">
        <div class="p-6 h-full flex flex-col">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold">Keranjang</h2>
                <button id="closeCartBtn" aria-label="Close cart">✕</button>
            </div>
            <div id="cartItems" class="mt-4 flex-1 overflow-auto"></div>
            <div class="mt-4 border-t pt-4">
                <div class="flex items-center justify-between text-sm text-gray-700">
                    <span>Subtotal</span>
                    <span id="cartSubtotal" class="font-semibold">Rp0</span>
                </div>
                <div class="mt-3">
                    <button id="checkoutBtn" class="w-full inline-flex items-center justify-center px-4 py-2 bg-[#1f1c1c] text-white rounded-md disabled:opacity-50">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </aside>
</div>


<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@endsection