<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SpeedRapid | Premium Store</title>
  <style>
    body { font-family: 'Segoe UI', sans-serif; margin: 0; background: #f4f4f4; overflow-x: hidden; }
    
    /* الطبقة الضبابية الخلفية (Overlay) */
    #cart-overlay {
      position: fixed;
      top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      display: none; /* مخفية في الأول */
      z-index: 1000;
    }

    .navbar { background: #222; color: white; padding: 1rem 5%; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 999; }
    
    .cart-tab {
      position: fixed; right: 0; top: 50%; transform: translateY(-50%);
      background: #ff4757; color: white; padding: 15px 10px; border-radius: 10px 0 0 10px;
      cursor: pointer; z-index: 1002; box-shadow: -2px 0 10px rgba(0,0,0,0.2);
      display: flex; flex-direction: column; align-items: center; transition: 0.3s;
    }

    #cart-sidebar { 
      position: fixed; right: -400px; top: 0; width: 350px; height: 100%; 
      background: white; box-shadow: -5px 0 15px rgba(0,0,0,0.3); transition: 0.4s; 
      z-index: 1001; padding: 25px; display: flex; flex-direction: column; 
    }
    #cart-sidebar.open { right: 0; }

    /* زر الإغلاق X الفوق */
    .close-cart {
      position: absolute; top: 15px; left: 15px; font-size: 1.5rem;
      cursor: pointer; color: #333; font-weight: bold; border: none; background: none;
    }

    .cart-items-container { flex: 1; overflow-y: auto; margin-top: 40px; border-bottom: 1px solid #eee; }
    .cart-item { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #f9f9f9; }
    .cart-item img { width: 50px; height: 50px; object-fit: cover; border-radius: 5px; }

    .products { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 25px; padding: 20px 5%; }
    .product-card { background: white; border-radius: 12px; padding: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; }
    .product-card img { width: 100%; height: 200px; object-fit: cover; border-radius: 8px; cursor: pointer; }
    .price { font-size: 1.2rem; font-weight: bold; color: #2ed573; margin: 10px 0; }
    .add-btn { background: #2f3542; color: white; border: none; padding: 12px; width: 100%; border-radius: 5px; cursor: pointer; font-weight: bold; }
    .add-btn:disabled { background: #95a5a6; cursor: not-allowed; }
    
    #checkout-section { display: none; margin-top: 15px; }
    .input-group input { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
    .whatsapp-btn { background: #25D366; color: white; border: none; padding: 15px; width: 100%; border-radius: 5px; cursor: pointer; font-weight: bold; width: 100%; }

    .hero { background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1200'); background-size: cover; height: 250px; color: white; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; }
    .categories { display: flex; justify-content: center; gap: 10px; padding: 20px; background: white; overflow-x: auto; }
    .categories button { padding: 8px 15px; border: none; border-radius: 20px; cursor: pointer; white-space: nowrap; }
    .categories button.active { background: #ff4757; color: white; }
    footer { text-align: center; padding: 20px; background: #222; color: white; margin-top: 20px; }
    .no-products { text-align: center; padding: 3rem; color: #7f8c8d; }
  </style>
</head>
<body>

  <div id="cart-overlay" onclick="toggleCart()"></div>

  <div class="cart-tab" id="floating-cart" onclick="toggleCart()">
    🛒 <span id="tab-count">0</span>
  </div>

  <header class="navbar">
    <h1 onclick="window.location.href='{{ route('user.products.index') }}'" style="cursor:pointer">SpeedRapid</h1>
    <div style="font-weight: bold; color: #ff4757;">Premium Store</div>
  </header>
 
  <div id="cart-sidebar">
    <button class="close-cart" onclick="toggleCart()">✕</button>
    
    <h2 style="margin:0; text-align: center;">Mon Panier</h2>
    
    <div class="cart-items-container" id="cart-list"></div>
    
    <div id="cart-summary">
      <h3 style="display:flex; justify-content:space-between; margin-top:15px;">
        Total: <span id="cart-total">0</span> DH
      </h3>
      <button class="add-btn" id="start-checkout-btn" onclick="showCheckoutForm()">Passer la commande</button>
      
      <div id="checkout-section">
        <div class="input-group">
          <input type="text" id="custName" placeholder="Nom Complet">
          <input type="text" id="custAddr" placeholder="Adresse et Ville">
        </div>
        <button class="whatsapp-btn" onclick="sendToWhatsApp()">Commander sur WhatsApp</button>
      </div>
    </div>
  </div>

  <section class="hero">
    <h1>Vente Flash & Nouveautés</h1>
    <p>Le meilleur du shopping</p>
  </section>

  <section class="categories" id="cat-filters">
    <button onclick="filterCat('all', this)" class="active">Tout</button>
    @foreach($categories as $category)
      <button onclick="filterCat({{ $category->id }}, this)" data-category-id="{{ $category->id }}">{{ $category->name }}</button>
    @endforeach
  </section>

  <section class="products" id="product-grid"></section>

  <footer><p>© {{ date('Y') }} SpeedRapid</p></footer>

  <script>
    // Products data from backend
    const storageUrl = '{{ asset("storage") }}';
    const baseUrl = '{{ url("/user/products") }}';
    const productsData = @json($products);
    const allProducts = productsData.map(p => ({
      id: p.id,
      category_id: p.category_id,
      title: p.name,
      price: parseFloat(p.price),
      img: p.images && p.images.length > 0 ? storageUrl + '/' + p.images[0].image_path : 'https://via.placeholder.com/400?text=No+Image',
      slug: p.slug,
      stock: p.stock,
      description: p.description
    }));

    let cart = JSON.parse(localStorage.getItem('speedRapidCart')) || [];

    // Render Functions
    function render(filter) {
      const grid = document.getElementById('product-grid');
      grid.innerHTML = '';
      const filtered = filter === 'all' ? allProducts : allProducts.filter(p => p.category_id == filter);

      if (filtered.length === 0) {
        grid.innerHTML = '<div class="no-products" style="grid-column: 1 / -1;"><p style="font-size: 1.2rem;">Aucun produit trouvé.</p></div>';
        return;
      }

      filtered.forEach(p => {
        const isOutOfStock = p.stock <= 0;
        const productUrl = baseUrl + '/' + p.id;
        grid.innerHTML += `
          <div class="product-card">
            <img src="${p.img}" onclick="window.location.href='${productUrl}'" alt="${p.title}">
            <h3 onclick="window.location.href='${productUrl}'" style="cursor:pointer; margin: 10px 0;">${p.title}</h3>
            <p class="price">${p.price.toFixed(2)} DH</p>
            <button class="add-btn" onclick="addToCart(${p.id})" ${isOutOfStock ? 'disabled' : ''}>
              ${isOutOfStock ? 'Rupture de stock' : '🛒 Ajouter au Panier'}
            </button>
          </div>`;
      });
    }

    // Cart Functions
    function toggleCart() {
      const sidebar = document.getElementById('cart-sidebar');
      const overlay = document.getElementById('cart-overlay');
      const floatingTab = document.getElementById('floating-cart');
      
      sidebar.classList.toggle('open');
      
      if(sidebar.classList.contains('open')) {
        overlay.style.display = 'block';
        floatingTab.style.right = '350px';
      } else {
        overlay.style.display = 'none';
        floatingTab.style.right = '0';
      }
    }

    function addToCart(productId) {
      const product = allProducts.find(item => item.id === productId);
      if (product && product.stock > 0) {
        cart.push({...product});
        localStorage.setItem('speedRapidCart', JSON.stringify(cart));
        updateCartUI();
        if(!document.getElementById('cart-sidebar').classList.contains('open')) toggleCart();
      }
    }

    function updateCartUI() {
      const list = document.getElementById('cart-list');
      const countLabel = document.getElementById('tab-count');
      const totalLabel = document.getElementById('cart-total');
      list.innerHTML = ''; 
      let total = 0;
      cart.forEach((item, index) => {
        total += item.price;
        list.innerHTML += `
          <div class="cart-item">
            <img src="${item.img}" alt="${item.title}">
            <div style="flex:1">
                <div style="font-weight:bold; font-size:0.9rem;">${item.title}</div>
                <div style="color:#27ae60;">${item.price.toFixed(2)} DH</div>
            </div>
            <button onclick="removeFromCart(${index})" style="border:none; color:red; background:none; cursor:pointer;">✕</button>
          </div>`;
      });
      countLabel.innerText = cart.length;
      totalLabel.innerText = total.toFixed(2);
    }

    function removeFromCart(index) {
      cart.splice(index, 1);
      localStorage.setItem('speedRapidCart', JSON.stringify(cart));
      updateCartUI();
    }

    function showCheckoutForm() {
      if(cart.length === 0) return alert("Votre panier est vide !");
      document.getElementById('checkout-section').style.display = 'block';
      document.getElementById('start-checkout-btn').style.display = 'none';
    }

    function sendToWhatsApp() {
      const name = document.getElementById('custName').value.trim();
      const addr = document.getElementById('custAddr').value.trim();
      if(!name || !addr) return alert("Nom et Adresse requis !");
      let message = `*Commande SpeedRapid*%0A*Client:* ${name}%0A*Adresse:* ${addr}%0A*Articles:*%0A`;
      cart.forEach((item, i) => { message += `- ${item.title} (${item.price.toFixed(2)} DH)%0A`; });
      message += `%0A*TOTAL: ${document.getElementById('cart-total').innerText} DH*`;
      window.open(`https://wa.me/212600000000?text=${message}`, '_blank');
    }

    function filterCat(c, btn) {
      document.querySelectorAll('#cat-filters button').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      render(c);
    }

    // Initialize
    updateCartUI();
    render('all');
  </script>
</body>
</html>
