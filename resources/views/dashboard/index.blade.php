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
</head>

<body>

    <!-- Include Sidebar -->
    @include('sidebar.index')

    <!-- Main Content -->
    <main class="main-content">
        <div class="top-bar">
            <div>
                <h2>Dashboard Overview</h2>
                <div class="date-display" style="color: var(--text-muted);">
                    {{ now()->format('l, d F Y') }}
                </div>
            </div>
        </div>

        <!-- 1. Top Stats Row (Including Action Button for Alignment) -->
        <div class="dashboard-grid">
            <!-- Revenue Card -->
            <div class="card stat-card">
                <div class="stat-info">
                    <div
                        style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem; width: 100%;">
                        <p>Pendapatan</p>
                        <select class="filter-select" style="font-size: 0.8rem;">
                            <option value="today">Hari Ini</option>
                            <option value="month" selected>Bulan Ini</option>
                        </select>
                    </div>
                    <h3>Rp 12,500,000</h3>
                    <p style="color: var(--success); font-size: 0.8rem;">
                        <i class="fas fa-arrow-up"></i> +15% dari bulan lalu
                    </p>
                </div>
                <div class="stat-icon bg-primary-light">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>

            <!-- Transactions Count -->
            <div class="card stat-card">
                <div class="stat-info">
                    <p>Total Transaksi</p>
                    <h3>1,250</h3>
                    <p style="color: var(--text-muted); font-size: 0.8rem;">Bulan Ini</p>
                </div>
                <div class="stat-icon bg-accent-light">
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>

            <!-- Quick Action: New Transaction (Moved here for alignment) -->
            <a href="{{ route('kasir.index') }}" class="btn-action-lg">
                <i class="fas fa-cash-register"></i>
                <span>Transaksi Baru</span>
            </a>
        </div>

        <!-- 2. Bottom Split Section -->
        <div class="dashboard-split" style="align-items: start;">

            <!-- Left Panel: Top Products -->
            <div class="card">
                <div class="section-header">
                    <div>
                        <h3>Obat Paling Laris</h3>
                        <p style="font-size: 0.8rem; color: var(--text-muted);">Produk dengan penjualan tertinggi</p>
                    </div>
                    <select class="filter-select" style="font-size: 0.85rem;">
                        <option value="month" selected>Bulan Ini</option>
                        <option value="day">Hari Ini</option>
                    </select>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Obat</th>
                                <th>Kategori</th>
                                <th>Terjual</th>
                                <th>Status</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Mock Data -->
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div
                                            style="width: 32px; height: 32px; background: #eee; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-capsules" style="color: var(--text-muted);"></i>
                                        </div>
                                        <span>Paracetamol 500mg</span>
                                    </div>
                                </td>
                                <td>Obat Bebas</td>
                                <td>450 Strip</td>
                                <td><span class="badge badge-success">Tersedia</span></td>
                                <td>Rp 5.000</td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div
                                            style="width: 32px; height: 32px; background: #eee; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-prescription-bottle-alt"
                                                style="color: var(--text-muted);"></i>
                                        </div>
                                        <span>Amoxicillin</span>
                                    </div>
                                </td>
                                <td>Antibiotik</td>
                                <td>210 Strip</td>
                                <td><span class="badge badge-warning">Menipis</span></td>
                                <td>Rp 12.000</td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div
                                            style="width: 32px; height: 32px; background: #eee; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-tablets" style="color: var(--text-muted);"></i>
                                        </div>
                                        <span>Vitamin C IPI</span>
                                    </div>
                                </td>
                                <td>Suplemen</td>
                                <td>180 Botol</td>
                                <td><span class="badge badge-success">Tersedia</span></td>
                                <td>Rp 8.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="margin-top: 1rem; text-align: center;">
                    <a href="#"
                        style="text-decoration: none; color: var(--primary); font-size: 0.9rem; font-weight: 500;">Lihat
                        Semua Data</a>
                </div>
            </div>

            <!-- Right Panel: Low Stock Alerts -->
            <div class="card" style="background: #fff;">
                <div class="section-header">
                    <h3>Stok Menipis</h3>
                    <i class="fas fa-exclamation-triangle" style="color: var(--danger);"></i>
                </div>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem;">Perlu restock segera</p>

                <div class="low-stock-list">
                    <!-- Item 1 -->
                    <div class="low-stock-item">
                        <div class="stock-icon">
                            <i class="fas fa-pills"></i>
                        </div>
                        <div class="stock-info">
                            <h5>Bodrex Migra</h5>
                            <p>Sisa: 2 Strip</p>
                        </div>
                        <div class="stock-count">Crit</div>
                    </div>

                    <!-- Item 2 -->
                    <div class="low-stock-item">
                        <div class="stock-icon">
                            <i class="fas fa-syringe"></i>
                        </div>
                        <div class="stock-info">
                            <h5>Spuit 3cc</h5>
                            <p>Sisa: 5 Pcs</p>
                        </div>
                        <div class="stock-count">Low</div>
                    </div>

                    <!-- Item 3 -->
                    <div class="low-stock-item">
                        <div class="stock-icon">
                            <i class="fas fa-prescription-bottle"></i>
                        </div>
                        <div class="stock-info">
                            <h5>Sirup OBH</h5>
                            <p>Sisa: 1 Botol</p>
                        </div>
                        <div class="stock-count">Crit</div>
                    </div>
                </div>

                <button
                    style="width: 100%; padding: 0.8rem; border: 1px solid var(--danger); background: transparent; color: var(--danger); border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s;"
                    onmouseover="this.style.background='rgba(231,76,60,0.1)'"
                    onmouseout="this.style.background='transparent'">
                    Buat Request Restock
                </button>
            </div>

        </div>

    </main>

</body>

</html>