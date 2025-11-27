window.addEventListener('DOMContentLoaded', () => {

  // // ================= RENDER PRODUK DI HOME =================
  // const productsGrid = document.getElementById('productsGrid');
  // if (productsGrid && window.KKM_PRODUCTS) {
  //   productsGrid.innerHTML = '';
  //   window.KKM_PRODUCTS.forEach(p => {
  //     const card = document.createElement('div');
  //     card.className = "bg-[#2a2727] rounded-lg overflow-hidden shadow hover:shadow-lg transition";
  //     card.innerHTML = `
  //       <img src="${p.image.startsWith('/') ? p.image : '/' + p.image}" alt="${p.name}" class="w-full h-56 object-cover">
  //       <div class="p-4 text-white">
  //         <h3 class="font-semibold">${p.name}</h3>
  //         <p class="text-yellow-400 font-bold mt-1">Rp${p.price.toLocaleString('id-ID')}</p>
  //         <div class="mt-3 flex gap-2">
  //           <a href="/product?id=${encodeURIComponent(p.id)}"
  //             class="flex-1 text-center py-2 bg-yellow-400 text-black rounded-md font-semibold hover:opacity-90">
  //             Detail
  //           </a>
  //           <button id="addToCartBtn" data-id="${p.id}"
  //             class="flex-1 text-center py-2 bg-yellow-400 text-black rounded-md font-semibold hover:opacity-90">
  //             Add to Cart
  //           </button>
  //         </div>
  //       </div>
  //     `;
  //     productsGrid.appendChild(card);
  //   });
  // }

  // ================== DRAWER KERANJANG ==================
  const cartDrawer = document.getElementById('cartDrawer');
  const cartPanel = document.getElementById('cartPanel');
  const cartBackdrop = document.getElementById('cartBackdrop');
  const cartItemsContainer = document.getElementById('cartItems');
  const cartSubtotal = document.getElementById('cartSubtotal');
  const cartCountBadge = document.getElementById('cartCountBadge');

  function openCart() {
    cartDrawer?.classList.remove('pointer-events-none');
    cartBackdrop?.classList.remove('opacity-0');
    cartPanel?.classList.remove('translate-x-full');
  }

  function closeCart() {
    cartDrawer?.classList.add('pointer-events-none');
    cartBackdrop?.classList.add('opacity-0');
    cartPanel?.classList.add('translate-x-full');
  }

  // 🧠 Event Delegation biar tombol cart berfungsi di semua halaman (home & product)
  document.addEventListener('click', (e) => {
    if (e.target.id === 'openCartBtn') openCart();
    if (e.target.id === 'closeCartBtn' || e.target.id === 'cartBackdrop') closeCart();
  });

  // ================== CART LOGIC ==================
  const CART_KEY = 'kkm_cart';

  function getCart() {
    return JSON.parse(localStorage.getItem(CART_KEY) || '[]');
  }

  function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
  }

  function updateCartCount() {
    const cart = getCart();
    if (!cartCountBadge) return;
    if (cart.length > 0) {
      cartCountBadge.textContent = cart.length;
      cartCountBadge.classList.remove('hidden');
    } else {
      cartCountBadge.classList.add('hidden');
    }
  }

  function renderCart() {
    if (!cartItemsContainer) return;
    const cart = getCart();
    cartItemsContainer.innerHTML = '';
    let subtotal = 0;

    cart.forEach((item, index) => {
      subtotal += item.price * item.qty;

      const div = document.createElement('div');
      div.className = 'flex items-center gap-3 border-b py-3';
      div.innerHTML = `
        <img src="${item.image.startsWith('/') ? item.image : '/' + item.image}" alt="${item.name}" class="w-16 h-16 object-cover rounded-md">
        <div class="flex-1">
          <div class="font-semibold text-gray-800">${item.name}</div>
          <div class="text-sm text-gray-600">Rp${item.price.toLocaleString('id-ID')} x ${item.qty}</div>
        </div>
        <button class="text-red-500 text-sm" data-index="${index}">Hapus</button>
      `;
      cartItemsContainer.appendChild(div);
    });

    if (cartSubtotal)
      cartSubtotal.textContent = 'Rp' + subtotal.toLocaleString('id-ID');

    // tombol hapus item
    cartItemsContainer.querySelectorAll('button[data-index]').forEach(btn => {
      btn.addEventListener('click', () => {
        const idx = parseInt(btn.getAttribute('data-index'));
        const cart = getCart();
        cart.splice(idx, 1);
        saveCart(cart);
        renderCart();
        updateCartCount();
      });
    });
  }

  // ================== ADD TO CART ==================
  document.addEventListener('click', (e) => {
    if (e.target && e.target.id === 'addToCartBtn') {
      const productId = e.target.dataset.id;
      
      
      
      if (!product) return;

      const cart = getCart();
      const existing = cart.find(item => item.id === product.id);
      if (existing) {
        existing.qty += 1;
      } else {
        cart.push({
          id: product.id,
          name: product.name,
          price: product.price,
          image: product.image,
          qty: 1
        });
      }

      saveCart(cart);
      updateCartCount();
      renderCart();
      openCart();
    }
  });

  // ================== INIT ==================
  updateCartCount();
  renderCart();

  // Ekspor fungsi ke global biar bisa dipanggil dari halaman lain
  window.renderCart = renderCart;
  window.updateCartCount = updateCartCount;
  window.openCart = openCart;
});

// =========================
// HERO SLIDER (ANIMATED SLIDE VERSION)
// =========================

const heroSlider = document.getElementById("heroSlider");
const prevSlide = document.getElementById("prevSlide");
const nextSlide = document.getElementById("nextSlide");

if (heroSlider) {

    const totalSlides = heroSlider.children.length;
    let index = 0;

    function updateSlide() {
        heroSlider.style.transform = `translateX(-${index * 100}%)`;
    }

    // Auto slide
    let autoPlay = setInterval(() => {
        index = (index + 1) % totalSlides;
        updateSlide();
    }, 5000);

    // Tombol next
    nextSlide?.addEventListener("click", () => {
        index = (index + 1) % totalSlides;
        updateSlide();
        resetAuto();
    });

    // Tombol prev
    prevSlide?.addEventListener("click", () => {
        index = (index - 1 + totalSlides) % totalSlides;
        updateSlide();
        resetAuto();
    });

    function resetAuto() {
        clearInterval(autoPlay);
        autoPlay = setInterval(() => {
            index = (index + 1) % totalSlides;
            updateSlide();
        }, 5000);
    }
}

