<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Obat - Zapotek</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <style>
        /* Local Styles for Table Actions */
        /* Modern Button Styles */
        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-edit {
            background: rgba(52, 152, 219, 0.1);
            color: #3498db;
        }

        .btn-edit:hover {
            background: #3498db;
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
        }

        .btn-delete:hover {
            background: #e74c3c;
            color: #fff;
            transform: translateY(-2px);
        }


        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .search-box {
            position: relative;
            width: 300px;
        }

        .search-box input {
            width: 100%;
            padding: 0.6rem 1rem 0.6rem 2.5rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            outline: none;
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .btn-add {
            background: var(--primary);
            color: #fff;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            transition: background 0.2s;
        }

        .btn-add:hover {
            background: var(--primary-dark);
        }

        /* Thumbnail Style */
        .img-thumbnail {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: #f1f3f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 1.2rem;
            object-fit: cover;
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
                <h2>Data Obat</h2>
                <div style="font-size: 0.85rem; color: var(--text-muted);">
                    Manajemen Stok dan Inventaris Apotek
                </div>
            </div>
            <!-- User Profile / Notif could go here -->
        </div>

        <div class="card">
            <!-- Toolbar -->
            <div class="toolbar">
                <form action="{{ route('obat.index') }}" method="GET" style="display: flex; justify-content: space-between; width: 100%; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div class="search-box" style="position: relative;">
                        <button type="submit" style="background: none; border: none; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); cursor: pointer;">
                            <i class="fas fa-search"></i>
                        </button>
                        <input type="text" name="search" placeholder="Cari obat, kode..." value="{{ request('search') }}" 
                               style="padding: 0.6rem 1rem 0.6rem 3.5rem; border: 1px solid var(--border-color); border-radius: 8px; outline: none; width: 250px;">
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <select name="kategori" class="filter-select" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            <option value="Obat Bebas" {{ request('kategori') == 'Obat Bebas' ? 'selected' : '' }}>Obat Bebas</option>
                            <option value="Obat Keras" {{ request('kategori') == 'Obat Keras' ? 'selected' : '' }}>Obat Keras</option>
                            <option value="Antibiotik" {{ request('kategori') == 'Antibiotik' ? 'selected' : '' }}>Antibiotik</option>
                            <option value="Alat Kesehatan" {{ request('kategori') == 'Alat Kesehatan' ? 'selected' : '' }}>Alat Kesehatan</option>
                            <option value="Salep" {{ request('kategori') == 'Salep' ? 'selected' : '' }}>Salep</option>
                            <option value="Suplemen" {{ request('kategori') == 'Suplemen' ? 'selected' : '' }}>Suplemen</option>
                        </select>
                        <a href="{{ route('obat.create') }}" class="btn-add">
                            <i class="fas fa-plus"></i> Tambah Obat
                        </a>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="8%">Gambar</th>
                            <th>Kode</th>
                            <th>Nama Obat</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Satuan</th>
                            <th>Harga Jual</th>
                            <th>Exp. Date</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($obats as $obat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="img-thumbnail">
                                        @if($obat->gambar)
                                            <img src="/images/obat/{{ $obat->gambar }}" alt="{{ $obat->nama_obat }}"
                                                style="width: 100%; height: 100%; border-radius: 8px; object-fit: cover;">
                                        @else
                                            <i class="fas fa-capsules"></i>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $obat->kode_obat }}</td>
                                <td>{{ $obat->nama_obat }}</td>
                                <td>{{ $obat->kategori }}</td>
                                <td>
                                    @if($obat->stok <= 5)
                                        <span class="badge badge-danger">{{ $obat->stok }}</span>
                                    @elseif($obat->stok <= 20)
                                        <span class="badge badge-warning">{{ $obat->stok }}</span>
                                    @else
                                        <span class="badge badge-success">{{ $obat->stok }}</span>
                                    @endif
                                </td>
                                <td>{{ $obat->satuan }}</td>
                                <td>Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                                <td>{{ $obat->expired_date }}</td>
                                <td>
                                    <form action="{{ route('obat.destroy', $obat->id) }}" method="POST"
                                        style="display: flex; gap: 5px;">
                                        <a href="{{ route('obat.edit', $obat->id) }}" class="action-btn btn-edit"
                                            title="Edit"><i class="fas fa-edit"></i></a>



                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete" title="Hapus"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination dummy -->
            <div
                style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem; color: var(--text-muted); font-size: 0.9rem;">
                <div>Menampilkan 5 dari 125 data</div>
                <div style="display: flex; gap: 5px;">
                    <button
                        style="padding: 0.5rem 1rem; border: 1px solid var(--border-color); background: #fff; border-radius: 6px; cursor: pointer;">Prev</button>
                    <button
                        style="padding: 0.5rem 1rem; border: 1px solid var(--primary); background: var(--primary); color: #fff; border-radius: 6px; cursor: pointer;">1</button>
                    <button
                        style="padding: 0.5rem 1rem; border: 1px solid var(--border-color); background: #fff; border-radius: 6px; cursor: pointer;">2</button>
                    <button
                        style="padding: 0.5rem 1rem; border: 1px solid var(--border-color); background: #fff; border-radius: 6px; cursor: pointer;">3</button>
                    <button
                        style="padding: 0.5rem 1rem; border: 1px solid var(--border-color); background: #fff; border-radius: 6px; cursor: pointer;">Next</button>
                </div>
            </div>

        </div>
    </main>


</body>

</html>