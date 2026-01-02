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
    @include('backend.sidebar.index')

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
                        <p>{{ $stats['revenue_label'] }}</p>
                        <select class="filter-select" style="font-size: 0.8rem;">
                            <option value="today">Hari Ini</option>
                            <option value="month" selected>Bulan Ini</option>
                        </select>
                    </div>
                    <h3>{{ $stats['revenue'] }}</h3>
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
                    <p>{{ $stats['transactions_label'] }}</p>
                    <h3>{{ $stats['transactions'] }}</h3>
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

            @if(Auth::user()->role == 'admin')
            <!-- Left Panel: Top Products (Admin Only) -->
            <div class="card">
                <div class="section-header">
                    <div>
                        <h3>Obat Paling Laris</h3>
                        <p style="font-size: 0.8rem; color: var(--text-muted);">Produk dengan penjualan tertinggi bulan ini</p>
                    </div>
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
                            @forelse($topProducts as $item)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div
                                            style="width: 32px; height: 32px; background: #eee; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                            @if($item->obat && $item->obat->gambar)
                                                <img src="{{ asset('images/obat/' . $item->obat->gambar) }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">
                                            @else
                                                <i class="fas fa-capsules" style="color: var(--text-muted);"></i>
                                            @endif
                                        </div>
                                        <span>{{ $item->obat->nama_obat ?? 'Deleted Item' }}</span>
                                    </div>
                                </td>
                                <td>{{ $item->obat->kategori ?? '-' }}</td>
                                <td>{{ $item->total_qty }} {{ $item->obat->satuan ?? '' }}</td>
                                <td>
                                    @if($item->obat->stok > 20)
                                        <span class="badge badge-success">Tersedia</span>
                                    @elseif($item->obat->stok > 0)
                                        <span class="badge badge-warning">Menipis</span>
                                    @else
                                        <span class="badge badge-danger">Habis</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($item->obat->harga ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-muted);">Belum ada data penjualan bulan ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Panel: Expiring Soon & Already Expired (Admin Only) -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                <!-- 1. Akan Kadaluarsa -->
                <div class="card" style="background: #fff;">
                    <div class="section-header">
                        <h3>Akan Kadaluarsa</h3>
                        <i class="fas fa-hourglass-half" style="color: var(--warning);"></i>
                    </div>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem;">Mendekati ED (< 5 Bulan)</p>

                    <div class="low-stock-list">
                        @forelse($expiringSoon as $obat)
                            @php
                                $expiryDate = \Carbon\Carbon::parse($obat->expired_date);
                                $diffInMonths = now()->diffInMonths($expiryDate, false);
                                $badgeColor = $diffInMonths <= 2 ? 'var(--danger)' : 'var(--warning)';
                                $badgeBg = $diffInMonths <= 2 ? 'rgba(231, 76, 60, 0.1)' : 'rgba(241, 196, 15, 0.1)';
                            @endphp
                            <div class="low-stock-item" style="border-left-color: {{ $badgeColor }}; border: 1px solid {{ $badgeBg }};">
                                <div class="stock-icon" style="color: {{ $badgeColor }}; background: {{ $badgeBg }};">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                                <div class="stock-info">
                                    <h5>{{ $obat->nama_obat }}</h5>
                                    <p>ED: {{ $expiryDate->format('d M Y') }}</p>
                                </div>
                                <div class="stock-count" style="color: {{ $badgeColor }}; background: {{ $badgeBg }};">
                                    {{ $expiryDate->diffForHumans() }}
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 1rem; color: var(--text-muted);">
                                <i class="fas fa-check" style="color: var(--success);"></i> Tidak ada data.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- 2. Sudah Kadaluarsa -->
                <div class="card" style="background: #fff; border: 1px solid rgba(231, 76, 60, 0.3);">
                    <div class="section-header">
                        <h3 style="color: var(--danger);">Sudah Kadaluarsa</h3>
                        <i class="fas fa-skull-crossbones" style="color: var(--danger);"></i>
                    </div>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem;">Segera tarik dari etalase!</p>

                    <div class="low-stock-list">
                        @forelse($alreadyExpired as $obat)
                            @php
                                $expiryDate = \Carbon\Carbon::parse($obat->expired_date);
                            @endphp
                            <div class="low-stock-item" style="border-left-color: #000; border: 1px solid #ccc; background: #fafafa;">
                                <div class="stock-icon" style="color: #555; background: #e0e0e0;">
                                    <i class="fas fa-ban"></i>
                                </div>
                                <div class="stock-info">
                                    <h5 style="color: #555; text-decoration: line-through;">{{ $obat->nama_obat }}</h5>
                                    <p>ED: {{ $expiryDate->format('d M Y') }}</p>
                                </div>
                                <div class="stock-count" style="color: #fff; background: var(--danger); font-size: 0.8rem;">
                                    {{ $expiryDate->diffForHumans() }}
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 1rem; color: var(--text-muted);">
                                <i class="fas fa-check-double" style="color: var(--success);"></i> Bersih! Tidak ada obat expired.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
            @else
            <!-- Transaction History (Staff Only) -->
            <div class="card" style="grid-column: 1 / -1;">
                <div class="section-header">
                    <h3>Riwayat Transaksi Singkat</h3>
                    <p style="font-size: 0.8rem; color: var(--text-muted);">Transaksi terakhir Anda</p>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No. Transaksi</th>
                                <th>Waktu</th>
                                <th>Total Item</th>
                                <th>Total Bayar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $trx)
                            <tr>
                                <td>{{ $trx->no_transaksi }}</td>
                                <td>{{ $trx->created_at->format('H:i') }} WIB</td>
                                <td>{{ $trx->items->count() }} Item</td>
                                <td>Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
                                <td><span class="badge badge-success">Selesai</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-muted);">Belum ada transaksi hari ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>

    </main>

</body>

</html>