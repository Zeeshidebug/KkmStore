<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>KKM Esports Merchandise</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
</head>

<body class="bg-[#1f1c1c] text-gray-800">

    {{-- HEADER --}}
    <header class="sticky top-0 z-40 bg-[#1f1c1c] backdrop-blur shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-4">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-yellow-400 to-amber-600 flex items-center justify-center text-white font-bold">
                        KKM
                    </div>
                    <nav class="hidden md:flex gap-4 items-center text-sm font-medium text-gray-300">
                        <a href="{{ url('/') }}#products" class="hover:text-yellow-400">Merch</a>
                        <a href="{{ url('/') }}#about" class="hover:text-yellow-400">About</a>
                        <a href="{{ url('/') }}#contact" class="hover:text-yellow-400">Contact</a>
                    </nav>
                </div>

                {{-- TOMBOL KERANJANG --}}
                <button id="openCartBtn" aria-label="Open cart"
                    class="relative inline-flex items-center px-3 py-2 border border-white text-white rounded-md hover:bg-white hover:text-black transition">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                    </svg>
                    <span id="cartCountBadge"
                        class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full px-1.5 hidden">0</span>
                </button>
            </div>
        </div>
    </header>

    {{-- KONTEN HALAMAN --}}
    @yield('content')

    {{-- ====== CART DRAWER GLOBAL (dipakai semua halaman) ====== --}}
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
                        <button id="checkoutBtn"
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-[#1f1c1c] text-white rounded-md disabled:opacity-50">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    {{-- === SCRIPTS GLOBAL === --}}
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>