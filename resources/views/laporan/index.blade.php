<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan - Zapotek</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <style>
        .filter-container {
            display: flex;
            gap: 1rem;
            align-items: flex-end;
            margin-bottom: 2rem;
            background: #fff;
            padding: 1.5rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            flex-wrap: wrap;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group label {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .form-control {
            padding: 0.6rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: inherit;
            color: var(--text-main);
            outline: none;
        }

        .btn-filter {
            background: var(--primary);
            color: #fff;
            padding: 0.6rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.2s;
        }

        .btn-filter:hover {
            background: var(--primary-dark);
        }

        .btn-export {
            background: #fff;
            color: var(--text-main);
            border: 1px solid var(--border-color);
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-export:hover {
            background: #f8f9fa;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .summary-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            border-left: 4px solid var(--primary);
        }

        .summary-card h4 {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .summary-card .value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-main);
        }
    </style>
</head>

<body>

    <!-- Include Sidebar -->
    @include('sidebar.index')

    <!-- Main Content -->
    <main class="main-content">
        <div class="top-bar">
            <div>
                <h2>Laporan Penjualan</h2>
                <div style="font-size: 0.85rem; color: var(--text-muted);">
                    Rekapitulasi transaksi dan pendapatan
                </div>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="#" class="btn-export">
                    <i class="fas fa-file-excel" style="color: #27ae60;"></i> Export Excel
                </a>
                <a href="#" class="btn-export">
                    <i class="fas fa-file-pdf" style="color: #c0392b;"></i> Export PDF
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-container">
            <div class="form-group">
                <label>Dari Tanggal</label>
                <input type="date" class="form-control" value="{{ date('Y-m-01') }}">
            </div>
            <div class="form-group">
                <label>Sampai Tanggal</label>
                <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
            </div>
            <div class="form-group">
                <label>Kasir</label>
                <select class="form-control" style="min-width: 150px;">
                    <option value="">Semua Kasir</option>
                    <option value="user1">Ahmad</option>
                    <option value="user2">Siti</option>
                </select>
            </div>
            <button class="btn-filter">
                <i class="fas fa-filter"></i> Tampilkan
            </button>
        </div>

        <!-- Summary Widgets -->
        <div class="summary-cards">
            <div class="summary-card">
                <h4>Total Omset</h4>
                <div class="value">Rp 12,500,000</div>
            </div>
            <div class="summary-card" style="border-left-color: var(--accent);">
                <h4>Total Transaksi</h4>
                <div class="value">150 Transaksi</div>
            </div>
            <div class="summary-card" style="border-left-color: var(--success);">
                <h4>Rata-rata / Transaksi</h4>
                <div class="value">Rp 83,000</div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="card">
            <div class="section-header">
                <h3>Riwayat Transaksi</h3>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No Inverse</th>
                            <th>Tanggal & Jam</th>
                            <th>Kasir</th>
                            <th>Metode Bayar</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Mock Data 1 -->
                        <tr>
                            <td style="font-weight: 600;">#TRX-8829</td>
                            <td>01 Jan 2026, 14:30</td>
                            <td>Ahmad</td>
                            <td><span class="badge badge-success">Tunai</span></td>
                            <td style="font-weight: 700;">Rp 45.000</td>
                            <td>
                                <a href="#" style="color: var(--primary); text-decoration: none; font-size: 0.9rem;">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        <!-- Mock Data 2 -->
                        <tr>
                            <td style="font-weight: 600;">#TRX-8828</td>
                            <td>01 Jan 2026, 14:15</td>
                            <td>Siti</td>
                            <td><span class="badge badge-warning">QRIS</span></td>
                            <td style="font-weight: 700;">Rp 120.000</td>
                            <td>
                                <a href="#" style="color: var(--primary); text-decoration: none; font-size: 0.9rem;">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        <!-- Mock Data 3 -->
                        <tr>
                            <td style="font-weight: 600;">#TRX-8827</td>
                            <td>01 Jan 2026, 13:45</td>
                            <td>Ahmad</td>
                            <td><span class="badge badge-success">Tunai</span></td>
                            <td style="font-weight: 700;">Rp 15.000</td>
                            <td>
                                <a href="#" style="color: var(--primary); text-decoration: none; font-size: 0.9rem;">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        <!-- Mock Data 4 -->
                        <tr>
                            <td style="font-weight: 600;">#TRX-8826</td>
                            <td>01 Jan 2026, 13:10</td>
                            <td>Siti</td>
                            <td><span class="badge badge-success">Tunai</span></td>
                            <td style="font-weight: 700;">Rp 200.000</td>
                            <td>
                                <a href="#" style="color: var(--primary); text-decoration: none; font-size: 0.9rem;">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>

</html>