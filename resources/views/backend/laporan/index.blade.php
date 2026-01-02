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
        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none; /* Hidden by default */
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal-overlay.show {
            opacity: 1;
        }

        .modal-content {
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            width: 90%;
            max-width: 400px;
            position: relative;
            transform: translateY(20px);
            transition: transform 0.3s ease;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .modal-overlay.show .modal-content {
            transform: translateY(0);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 1.25rem;
            color: var(--text-main);
        }

        .close-modal {
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-muted);
            line-height: 1;
        }

        .close-modal:hover {
            color: var(--danger);
        }
    </style>
</head>

<body>

    <!-- Include Sidebar -->
    @include('backend.sidebar.index')

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
        <form action="{{ route('laporan.index') }}" method="GET" class="filter-container">
            <div class="form-group">
                <label>Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date', date('Y-m-01')) }}">
            </div>
            <div class="form-group">
                <label>Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date', date('Y-m-d')) }}">
            </div>
            @if(Auth::user()->role == 'admin')
            <div class="form-group">
                <label>Kasir</label>
                <select name="user_id" class="form-control" style="min-width: 150px;">
                    <option value="">Semua Kasir</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <button type="submit" class="btn-filter">
                <i class="fas fa-filter"></i> Tampilkan
            </button>
        </form>

        <!-- Summary Widgets -->
        <div class="summary-cards">
            <div class="summary-card">
                <h4>Total Omset</h4>
                <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </div>
            <div class="summary-card" style="border-left-color: var(--accent);">
                <h4>Total Transaksi</h4>
                <div class="value">{{ $totalTransaksi }} Transaksi</div>
            </div>
            <div class="summary-card" style="border-left-color: var(--success);">
                <h4>Rata-rata / Transaksi</h4>
                <div class="value">Rp {{ number_format($averageTransaksi, 0, ',', '.') }}</div>
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
                            <th>No Invoice</th>
                            <th>Tanggal & Jam</th>
                            <th>Kasir</th>
                            <th>Metode Bayar</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                        <tr>
                            <td style="font-weight: 600;">#{{ $trx->no_transaksi }}</td>
                            <td>{{ $trx->created_at->format('d M Y, H:i') }}</td>
                            <td>{{ $trx->user->name ?? 'Unknown' }}</td>
                            <td><span class="badge badge-success">Tunai</span></td>
                            <td style="font-weight: 700;">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
                            <td>
                                <button class="action-btn" style="background: none; border: none; color: var(--primary); font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; gap: 5px; font-weight: 500;" 
                                        onclick='showDetailModal(@json($trx))'>
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                                <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 0.5rem; display: block;"></i>
                                Tidak ada data transaksi untuk periode ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Detail Transaction Modal -->
    <div id="detailModal" class="modal-overlay">
        <div class="modal-content" style="max-width: 500px;">
            <div class="modal-header">
                <h3 id="modalTitle">Detail Transaksi</h3>
                <span class="close-modal" onclick="closeDetailModal()">&times;</span>
            </div>
            <div class="modal-body">
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">
                    <div>
                        <span style="display: block; font-size: 0.8rem; color: #888;">No Invoice</span>
                        <strong id="modalInvoice" style="color: var(--primary);">#TRX-0000</strong>
                    </div>
                    <div style="text-align: right;">
                        <span style="display: block; font-size: 0.8rem; color: #888;">Tanggal</span>
                        <span id="modalDate" style="font-weight: 500;">01 Jan 2023, 10:00</span>
                    </div>
                </div>
                
                <div style="background: #f8f9fa; border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                    <h5 style="margin-bottom: 0.5rem; font-size: 0.9rem; color: #555;">Daftar Item</h5>
                    <ul id="modalItems" style="list-style: none; padding: 0; margin: 0; font-size: 0.9rem;">
                        <!-- Items rendered by JS -->
                    </ul>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; padding-top: 1rem; border-top: 2px dashed #eee;">
                    <span style="font-size: 1rem; font-weight: 600;">Total Bayar</span>
                    <span id="modalTotal" style="font-size: 1.2rem; font-weight: 700; color: var(--primary);">Rp 0</span>
                </div>
                
                <div style="margin-top: 0.5rem; text-align: right;">
                     <span style="font-size: 0.8rem; color: #888;">Kasir: <span id="modalKasir">-</span></span>
                </div>
            </div>
            <div class="modal-footer" style="padding-top: 0; border: none;">
                <button class="btn-filter" style="width: 100%;" onclick="closeDetailModal()">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function showDetailModal(trx) {
            // Populate Modal Data
            document.getElementById('modalInvoice').textContent = '#' + trx.no_transaksi;
            
            // Format Date (Simple JS approach, ideally use library or backend formatted string)
            const date = new Date(trx.created_at);
            const formattedDate = date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) + ', ' + 
                                  date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            document.getElementById('modalDate').textContent = formattedDate;

            // Clear and Populate Items
            const itemsList = document.getElementById('modalItems');
            itemsList.innerHTML = '';
            
            trx.items.forEach(item => {
                const li = document.createElement('li');
                li.style.display = 'flex';
                li.style.justifyContent = 'space-between';
                li.style.marginBottom = '5px';
                li.innerHTML = `
                    <span>${item.nama_obat} <span style="color: #888; font-size: 0.8rem;">x${item.qty}</span></span>
                    <span style="font-weight: 500;">Rp ${(item.price || item.subtotal || (item.harga * item.qty)).toLocaleString('id-ID')}</span>
                `;
                // Note: assuming item structure has price detail, fallback to rough calc if needed. 
                // Based on DB structure, we might only have subtotal if stored, or calculate live.
                // Re-checking DB schema in mind: transaction_items usually have 'subtotal'
                li.querySelector('span:last-child').textContent = 'Rp ' + Number(item.subtotal).toLocaleString('id-ID');
                itemsList.appendChild(li);
            });

            document.getElementById('modalTotal').textContent = 'Rp ' + Number(trx.total_bayar).toLocaleString('id-ID');
            document.getElementById('modalKasir').textContent = trx.user ? trx.user.name : 'Unknown';

            // Show Modal
            const modal = document.getElementById('detailModal');
            modal.style.display = 'flex';
            setTimeout(() => {
                modal.classList.add('show');
            }, 10);
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        // Close on outside click
        window.onclick = function(event) {
            const modal = document.getElementById('detailModal');
            if (event.target == modal) {
                closeDetailModal();
            }
        }
    </script>
</body>

</html>
```