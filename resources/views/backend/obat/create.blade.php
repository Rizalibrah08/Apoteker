
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Obat - Zapotek</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .form-card {
            background: #fff;
            padding: 2rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            max-width: 800px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
        }

        .btn-submit {
            background: var(--primary);
            color: #fff;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .alert-danger {
            background: rgba(231, 76, 60, 0.1);
            color: var(--danger);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    @include('backend.sidebar.index')

    <main class="main-content">
        <div class="top-bar">
            <div>
                <h2>Tambah Obat Baru</h2>
                <div style="font-size: 0.85rem; color: var(--text-muted);">Isi form berikut untuk menambahkan stok obat
                    baru</div>
            </div>
            <a href="{{ route('obat.index') }}" style="text-decoration: none; color: var(--text-muted);"><i
                    class="fas fa-arrow-left"></i> Kembali</a>
        </div>

        <div class="form-card">
            @if ($errors->any())
                <div class="alert-danger">
                    <ul style="margin-left: 1.5rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('obat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Kode Obat</label>
                    <input type="text" name="kode_obat" class="form-control" placeholder="Contoh: OBT-001"
                        value="{{ old('kode_obat') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Obat</label>
                    <input type="text" name="nama_obat" class="form-control" placeholder="Nama Obat"
                        value="{{ old('nama_obat') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-control">
                        <option value="Obat Bebas">Obat Bebas</option>
                        <option value="Obat Keras">Obat Keras</option>
                        <option value="Antibiotik">Antibiotik</option>
                        <option value="Alat Kesehatan">Alat Kesehatan</option>
                        <option value="Salep">Salep</option>
                        <option value="Suplemen">Suplemen</option>
                    </select>
                </div>

                <div class="form-group" style="display: flex; gap: 1rem;">
                    <div style="flex: 1;">
                        <label class="form-label">Stok (Min: 2)</label>
                        <input type="number" name="stok" class="form-control" min="2" value="{{ old('stok') }}"
                            required>
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label">Satuan</label>
                        <select name="satuan" class="form-control">
                            <option value="Strip">Strip</option>
                            <option value="Botol">Botol</option>
                            <option value="Pcs">Pcs</option>
                            <option value="Box">Box</option>
                            <option value="Tablet">Tablet</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" style="display: flex; gap: 1rem;">
                    <div style="flex: 1;">
                        <label class="form-label">Harga Jual (Rp)</label>
                        <input type="number" name="harga" class="form-control" value="{{ old('harga') }}" required>
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label">Tanggal Kadaluarsa</label>
                        <input type="date" name="expired_date" class="form-control" value="{{ old('expired_date') }}"
                            required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Gambar Obat</label>
                    <input type="file" name="gambar" class="form-control">
                </div>

                <button type="submit" class="btn-submit">Simpan Data</button>
            </form>
        </div>
    </main>
</body>

</html>