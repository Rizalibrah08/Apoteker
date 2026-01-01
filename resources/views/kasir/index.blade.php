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
</head>

<body>

    <!-- Include Sidebar -->
    @include('sidebar.index')

    <!-- Main Content -->
    <main class="main-content" style="height: 100vh; overflow: hidden; padding-bottom: 0;">

        <div class="pos-layout">

            <!-- LEFT: Product Catalog -->
            <div class="catalog-section">
                <!-- Search -->
                <div class="search-bar-container">
                    <i class="fas fa-search" style="color: var(--text-muted);"></i>
                    <input type="text" class="search-input" placeholder="Cari obat, kategori, atau scan barcode...">
                    <i class="fas fa-barcode" style="font-size: 1.5rem; color: var(--text-main); cursor: pointer;"></i>
                </div>

                <!-- Filters -->
                <div class="category-filter">
                    <div class="filter-pill active">Semua</div>
                    <div class="filter-pill">Obat Bebas</div>
                    <div class="filter-pill">Obat Keras</div>
                    <div class="filter-pill">Vitamin & Suplemen</div>
                    <div class="filter-pill">Alat Kesehatan</div>
                    <div class="filter-pill">Ibu & Anak</div>
                </div>

                <!-- Grid -->
                <div class="product-grid">
                    <!-- Product 1 -->
                    <div class="product-card">
                        <div class="product-img">
                            <i class="fas fa-capsules"></i>
                        </div>
                        <div class="product-info">
                            <h5>Paracetamol 500mg</h5>
                            <p>Strip 10 Tablet</p>
                        </div>
                        <div class="product-meta">
                            <span class="price-tag">Rp 5.000</span>
                            <span class="stock-tag">Stok: 120</span>
                        </div>
                    </div>

                    <!-- Product 2 -->
                    <div class="product-card">
                        <div class="product-img">
                            <i class="fas fa-prescription-bottle-alt"></i>
                        </div>
                        <div class="product-info">
                            <h5>Amoxicillin 500mg</h5>
                            <p>Strip 10 Kaplet</p>
                        </div>
                        <div class="product-meta">
                            <span class="price-tag">Rp 12.000</span>
                            <span class="stock-tag">Stok: 45</span>
                        </div>
                    </div>

                    <!-- Product 3 -->
                    <div class="product-card">
                        <div class="product-img">
                            <i class="fas fa-tablets"></i>
                        </div>
                        <div class="product-info">
                            <h5>Vitamin C IPI</h5>
                            <p>Botol 45 Tablet</p>
                        </div>
                        <div class="product-meta">
                            <span class="price-tag">Rp 8.000</span>
                            <span class="stock-tag">Stok: 50</span>
                        </div>
                    </div>

                    <!-- Product 4 -->
                    <div class="product-card">
                        <div class="product-img">
                            <i class="fas fa-band-aid"></i>
                        </div>
                        <div class="product-info">
                            <h5>Hansaplast Kain</h5>
                            <p>Box 100 Lembar</p>
                        </div>
                        <div class="product-meta">
                            <span class="price-tag">Rp 45.000</span>
                            <span class="stock-tag">Stok: 20</span>
                        </div>
                    </div>

                    <!-- Product 5 -->
                    <div class="product-card">
                        <div class="product-img">
                            <i class="fas fa-pump-medical"></i>
                        </div>
                        <div class="product-info">
                            <h5>Hand Sanitizer</h5>
                            <p>Botol 100ml</p>
                        </div>
                        <div class="product-meta">
                            <span class="price-tag">Rp 15.000</span>
                            <span class="stock-tag">Stok: 80</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Cart -->
            <div class="cart-section">
                <div class="cart-header">
                    <h4>Keranjang</h4>
                    <span class="badge" style="background: #eee; color: #333;">Order #1023</span>
                </div>

                <div class="cart-items">
                    <!-- Item -->
                    <div class="cart-item">
                        <div class="item-qty-control">
                            <button class="btn-qty">+</button>
                            <span style="font-weight: 600; font-size: 0.9rem;">2</span>
                            <button class="btn-qty">-</button>
                        </div>
                        <div class="item-details">
                            <h6>Paracetamol 500mg</h6>
                            <small>Rp 5.000 / Strip</small>
                        </div>
                        <div class="item-total">Rp 10.000</div>
                    </div>

                    <!-- Item -->
                    <div class="cart-item">
                        <div class="item-qty-control">
                            <button class="btn-qty">+</button>
                            <span style="font-weight: 600; font-size: 0.9rem;">1</span>
                            <button class="btn-qty">-</button>
                        </div>
                        <div class="item-details">
                            <h6>Vitamin C IPI</h6>
                            <small>Rp 8.000 / Botol</small>
                        </div>
                        <div class="item-total">Rp 8.000</div>
                    </div>
                </div>

                <div class="cart-footer">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>Rp 18.000</span>
                    </div>
                    <div class="summary-row">
                        <span>Pajak (0%)</span>
                        <span>Rp 0</span>
                    </div>
                    <div class="total-row">
                        <span>Total Bayar</span>
                        <span style="color: var(--primary);">Rp 18.000</span>
                    </div>

                    <div style="display: flex; gap: 10px; margin-bottom: 1rem;">
                        <button class="btn-pay btn-hold" style="background: white; color: var(--text-muted);">
                            <i class="fas fa-pause"></i> Hold
                        </button>
                        <button class="btn-pay btn-hold"
                            style="background: white; color: var(--danger); border-color: var(--danger);">
                            <i class="fas fa-trash"></i> Batal
                        </button>
                    </div>

                    <button class="btn-pay">
                        <i class="fas fa-print"></i> Bayar & Cetak
                    </button>
                </div>
            </div>

        </div>

    </main>

</body>

</html>