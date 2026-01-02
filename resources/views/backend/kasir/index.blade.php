<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kasir - Zapotek</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kasir.css') }}">
    <style>
        .cart-empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 300px;
            color: var(--text-muted);
            text-align: center;
        }

        .cart-empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .cart-item-img {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            object-fit: cover;
            margin-right: 10px;
            background: #f1f3f5;
        }

        .item-row {
            display: flex;
            align-items: center;
        }

        /* Stock States */
        .product-card.stock-empty {
            opacity: 0.6;
            cursor: not-allowed;
            background: #f8f9fa;
        }

        .product-card.stock-empty:hover {
            transform: none;
            box-shadow: none;
        }

        /* 
         Removed border styles for stock-critical and stock-low as per user request.
         Only empty stock gets the gray style.
        */

        .product-img {
            position: relative; /* Contain absolute overlay */
            overflow: hidden; /* Ensure overlay doesn't leak */
        }

        .sold-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(255, 255, 255, 0.7);
            display: flex;
            align-items: center; justify-content: center;
            font-weight: bold;
            color: var(--danger);
            font-size: 1.2rem;
            transform: rotate(-15deg);
            z-index: 2;
        }
    </style>
</head>

<body>

    <!-- Include Sidebar -->
    @include('backend.sidebar.index')

    <!-- Main Content -->
    <main class="main-content" style="height: 100vh; overflow: hidden; padding-bottom: 0;">

        <div class="pos-layout">

            <!-- LEFT: Product Catalog -->
            <div class="catalog-section">
                <!-- Search -->
                <div class="search-bar-container">
                    <i class="fas fa-search" style="color: var(--text-muted);"></i>
                    <input type="text" id="searchInput" class="search-input"
                        placeholder="Cari obat, kategori, atau scan barcode..." onkeyup="filterProducts()">
                    <i class="fas fa-barcode" style="font-size: 1.5rem; color: var(--text-main); cursor: pointer;"></i>
                </div>

                <!-- Filters -->
                <div class="category-filter">
                    <div class="filter-pill active" onclick="filterCategory('all', this)">Semua</div>
                    <div class="filter-pill" onclick="filterCategory('Obat Bebas', this)">Obat Bebas</div>
                    <div class="filter-pill" onclick="filterCategory('Obat Keras', this)">Obat Keras</div>
                    <div class="filter-pill" onclick="filterCategory('Suplemen', this)">Vitamin & Suplemen</div>
                    <div class="filter-pill" onclick="filterCategory('Alat Kesehatan', this)">Alat Kesehatan</div>
                </div>

                <!-- Grid -->
                <div class="product-grid" id="productGrid">
                    @foreach($obats as $obat)
                        <div class="product-card {{ $obat->stok <= 0 ? 'stock-empty' : '' }}" 
                             data-name="{{ strtolower($obat->nama_obat) }}"
                             data-category="{{ $obat->kategori }}"
                             @if($obat->stok > 0)
                                onclick="addToCart({{ $obat->id }}, '{{ $obat->nama_obat }}', {{ $obat->harga }}, '{{ $obat->gambar ? asset('images/obat/' . $obat->gambar) : '' }}', '{{ $obat->satuan }}')"
                             @endif
                        >
                            <div class="product-img">
                                @if($obat->stok <= 0)
                                    <div class="sold-overlay">HABIS</div>
                                @endif

                                @if($obat->gambar)
                                    <img src="{{ asset('images/obat/' . $obat->gambar) }}" alt="{{ $obat->nama_obat }}"
                                        style="width: 100%; height: 100%; object-fit: contain; padding: 10px;">
                                @else
                                    <i class="fas fa-capsules"></i>
                                @endif
                            </div>
                            <div class="product-info">
                                <h5>{{ $obat->nama_obat }}</h5>
                                <p>{{ $obat->satuan }}</p>
                            </div>
                            <div class="product-meta">
                                <span class="price-tag">Rp {{ number_format($obat->harga, 0, ',', '.') }}</span>
                                <span class="stock-tag">Stok: {{ $obat->stok }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- RIGHT: Cart -->
            <div class="cart-section">
                <div class="cart-header">
                    <h4>Keranjang</h4>
                    <span class="badge" style="background: #eee; color: #333;" id="orderId">New Order</span>
                </div>

                <div class="cart-items" id="cartItems">
                    <!-- Empty State -->
                    <div class="cart-empty-state">
                        <i class="fas fa-shopping-basket"></i>
                        <p>Keranjang masih kosong.<br>Klik produk untuk menambahkan.</p>
                    </div>
                </div>

                <div class="cart-footer">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="subtotal">Rp 0</span>
                    </div>
                    <div class="summary-row">
                        <span>Pajak (0%)</span>
                        <span>Rp 0</span>
                    </div>
                    <div class="total-row">
                        <span>Total Bayar</span>
                        <span style="color: var(--primary);" id="total">Rp 0</span>
                    </div>

                    <div style="display: flex; gap: 10px; margin-bottom: 1rem;">
                        <button class="btn-pay btn-hold" style="background: white; color: var(--text-muted);"
                            onclick="alert('Fitur Hold belum tersedia')">
                            <i class="fas fa-pause"></i> Hold
                        </button>
                        <button class="btn-pay btn-hold" onclick="clearCart()"
                            style="background: white; color: var(--danger); border-color: var(--danger);">
                            <i class="fas fa-trash"></i> Batal
                        </button>
                    </div>

                    <button class="btn-pay" onclick="processPayment()">
                        <i class="fas fa-print"></i> Bayar & Cetak
                    </button>
                </div>
            </div>

        </div>

    </main>

    <!-- Payment Modal -->
    <div id="paymentModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Konfirmasi Pembayaran</h3>
                <span class="close-modal" onclick="closePaymentModal()">&times;</span>
            </div>
            <div class="modal-body">
                <div style="text-align: center; margin-bottom: 20px;">
                    <p style="color: var(--text-muted); margin-bottom: 5px;">Total Tagihan</p>
                    <h2 style="color: var(--primary); font-size: 2.5rem; font-weight: 700;" id="modalTotal">Rp 0</h2>
                </div>
                
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Uang Tunai (Rp)</label>
                    <input type="number" id="cashInput" class="form-control" placeholder="Masukkan jumlah uang..." 
                           style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 1.1rem;"
                           onkeyup="calculateChange()">
                </div>

                <div class="change-info" style="display: flex; justify-content: space-between; padding: 15px; background: var(--bg-light); border-radius: 8px; margin-bottom: 20px;">
                    <span style="font-weight: 600;">Kembalian:</span>
                    <span style="font-weight: 700; color: var(--success);" id="changeAmount">Rp 0</span>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <button class="btn-pay" style="background: var(--text-muted);" onclick="closePaymentModal()">Batal</button>
                    <button class="btn-pay" onclick="confirmPayment()">Bayar & Cetak</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 10000;"></div>

    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        
        .modal-content {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            width: 90%;
            max-width: 450px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
            animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .close-modal {
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-muted);
            transition: color 0.2s;
        }
        
        .close-modal:hover {
            color: var(--danger);
        }

        @keyframes slideUp {
            from { transform: translateY(40px) scale(0.95); opacity: 0; }
            to { transform: translateY(0) scale(1); opacity: 1; }
        }

        /* Toast Animation */
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>

    <script>
        let cart = [];

        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount);
        }

        function addToCart(id, name, price, image, unit) {
            const existingItem = cart.find(item => item.id === id);

            if (existingItem) {
                existingItem.qty++;
            } else {
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    image: image,
                    unit: unit,
                    qty: 1
                });
            }
            renderCart();
        }

        function updateQty(id, change) {
            const item = cart.find(item => item.id === id);
            if (item) {
                item.qty += change;
                if (item.qty <= 0) {
                    removeFromCart(id);
                } else {
                    renderCart();
                }
            }
        }

        function removeFromCart(id) {
            cart = cart.filter(item => item.id !== id);
            renderCart();
        }

        function clearCart() {
            if (cart.length > 0 && confirm('Kosongkan keranjang?')) {
                cart = [];
                renderCart();
            }
        }

        function renderCart() {
            const cartContainer = document.getElementById('cartItems');
            const subtotalEl = document.getElementById('subtotal');
            const totalEl = document.getElementById('total');

            if (cart.length === 0) {
                cartContainer.innerHTML = `
                    <div class="cart-empty-state">
                        <i class="fas fa-shopping-basket"></i>
                        <p>Keranjang masih kosong.<br>Klik produk untuk menambahkan.</p>
                    </div>`;
                subtotalEl.innerText = formatRupiah(0);
                totalEl.innerText = formatRupiah(0);
                return;
            }

            let html = '';
            let total = 0;

            cart.forEach(item => {
                const itemTotal = item.price * item.qty;
                total += itemTotal;

                // Image handling
                const imgHtml = item.image ? `<img src="${item.image}" class="cart-item-img" alt="${item.name}">` : `<div class="cart-item-img" style="display:flex;align-items:center;justify-content:center;"><i class="fas fa-capsules"></i></div>`;

                html += `
                    <div class="cart-item">
                        <div class="item-qty-control">
                            <button class="btn-qty" onclick="updateQty(${item.id}, 1)">+</button>
                            <span style="font-weight: 600; font-size: 0.9rem;">${item.qty}</span>
                            <button class="btn-qty" onclick="updateQty(${item.id}, -1)">-</button>
                        </div>
                        <div class="item-row" style="flex: 1; margin-left: 10px;">
                            ${imgHtml}
                            <div class="item-details">
                                <h6 style="margin:0; font-size: 0.95rem;">${item.name}</h6>
                                <small style="color: var(--text-muted);">${formatRupiah(item.price)} / ${item.unit}</small>
                            </div>
                        </div>
                        <div class="item-total" style="font-weight: 600;">${formatRupiah(itemTotal)}</div>
                    </div>
                `;
            });

            cartContainer.innerHTML = html;
            subtotalEl.innerText = formatRupiah(total);
            totalEl.innerText = formatRupiah(total);
        }

        function filterProducts() {
            const searchText = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.product-card');

            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                if (name.includes(searchText)) {
                    card.style.display = "flex";
                } else {
                    card.style.display = "none";
                }
            });
        }

        function filterCategory(category, element) {
            // Active pill style
            document.querySelectorAll('.filter-pill').forEach(pill => pill.classList.remove('active'));
            element.classList.add('active');

            const cards = document.querySelectorAll('.product-card');
            cards.forEach(card => {
                const itemCat = card.getAttribute('data-category');
                if (category === 'all' || itemCat === category) {
                    card.style.display = "flex";
                } else {
                    card.style.display = "none";
                }
            });
        }

        // --- Payment Modal Logic ---

        function processPayment() {
            if (cart.length === 0) {
                showToast('Keranjang kosong!', 'error');
                return;
            }
            
            // Open Modal
            const totalBayar = cart.reduce((acc, item) => acc + (item.price * item.qty), 0);
            document.getElementById('modalTotal').innerText = formatRupiah(totalBayar);
            document.getElementById('paymentModal').style.display = 'flex';
            document.getElementById('cashInput').value = '';
            document.getElementById('changeAmount').innerText = 'Rp 0';
            document.getElementById('cashInput').focus();
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').style.display = 'none';
        }

        function calculateChange() {
            const total = cart.reduce((acc, item) => acc + (item.price * item.qty), 0);
            const cash = parseFloat(document.getElementById('cashInput').value) || 0;
            const change = cash - total;
            
            if (change >= 0) {
                document.getElementById('changeAmount').innerText = formatRupiah(change);
                document.getElementById('changeAmount').style.color = 'var(--success)';
            } else {
                document.getElementById('changeAmount').innerText = 'Kurang ' + formatRupiah(Math.abs(change));
                document.getElementById('changeAmount').style.color = 'var(--danger)';
            }
        }

        // --- Toast Notification Logic ---

        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            // Styles
            const bgColor = type === 'success' ? '#fff' : '#fff';
            const borderColor = type === 'success' ? 'var(--success)' : 'var(--danger)';
            const icon = type === 'success' ? '<i class="fas fa-check-circle" style="color: var(--success); font-size: 1.2rem;"></i>' : '<i class="fas fa-times-circle" style="color: var(--danger); font-size: 1.2rem;"></i>';
            
            toast.style.cssText = `
                background: ${bgColor};
                border-left: 5px solid ${borderColor};
                color: #333;
                padding: 15px 20px;
                border-radius: 8px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.15);
                margin-bottom: 10px;
                display: flex;
                align-items: center;
                gap: 12px;
                min-width: 300px;
                animation: slideInRight 0.3s ease-out;
                font-family: 'Helvetica', sans-serif;
            `;
            
            toast.innerHTML = `
                ${icon}
                <div>
                    <h5 style="margin: 0; font-size: 1rem; font-weight: 600;">${type === 'success' ? 'Berhasil' : 'Gagal'}</h5>
                    <p style="margin: 2px 0 0; font-size: 0.9rem; color: #666;">${message}</p>
                </div>
            `;
            
            container.appendChild(toast);
            
            // Auto remove
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                toast.style.transition = 'all 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }

        function confirmPayment() {
            const totalBayar = cart.reduce((acc, item) => acc + (item.price * item.qty), 0);
            const cash = parseFloat(document.getElementById('cashInput').value) || 0;

            if (cash < totalBayar) {
                showToast('Uang tunai tidak mencukupi!', 'error');
                return;
            }

            // Send to Backend
            fetch('{{ route("kasir.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart: cart,
                    total_bayar: totalBayar
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closePaymentModal();
                    
                    // Show Toast
                    showToast(`Transaksi ${data.transaction_id} berhasil disimpan!`);
                    
                    cart = [];
                    renderCart();
                    
                    // Optional delay refresh
                    // setTimeout(() => location.reload(), 2000);
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan sistem.', 'error');
            });
        }
    </script>
</body>

</html>