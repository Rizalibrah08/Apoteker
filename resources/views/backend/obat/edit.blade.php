<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Obat - Zapotek</title>
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
                <h2>Edit Obat</h2>
                <div style="font-size: 0.85rem; color: var(--text-muted);">Perbarui informasi data obat</div>
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

            <form action="{{ route('obat.update', $obat->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Kode Obat</label>
                    <input type="text" name="kode_obat" class="form-control" value="{{ $obat->kode_obat }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Obat</label>
                    <input type="text" name="nama_obat" class="form-control" value="{{ $obat->nama_obat }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-control">
                        <option value="Obat Bebas" {{ $obat->kategori == 'Obat Bebas' ? 'selected' : '' }}>Obat Bebas
                        </option>
                        <option value="Obat Keras" {{ $obat->kategori == 'Obat Keras' ? 'selected' : '' }}>Obat Keras
                        </option>
                        <option value="Antibiotik" {{ $obat->kategori == 'Antibiotik' ? 'selected' : '' }}>Antibiotik
                        </option>
                        <option value="Alat Kesehatan" {{ $obat->kategori == 'Alat Kesehatan' ? 'selected' : '' }}>Alat
                            Kesehatan</option>
                        <option value="Salep" {{ $obat->kategori == 'Salep' ? 'selected' : '' }}>Salep</option>
                        <option value="Suplemen" {{ $obat->kategori == 'Suplemen' ? 'selected' : '' }}>Suplemen</option>
                    </select>
                </div>

                <div class="form-group" style="display: flex; gap: 1rem;">
                    <div style="flex: 1;">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" value="{{ $obat->stok }}" required>
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label">Satuan</label>
                        <select name="satuan" class="form-control">
                            <option value="Strip" {{ $obat->satuan == 'Strip' ? 'selected' : '' }}>Strip</option>
                            <option value="Botol" {{ $obat->satuan == 'Botol' ? 'selected' : '' }}>Botol</option>
                            <option value="Pcs" {{ $obat->satuan == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                            <option value="Box" {{ $obat->satuan == 'Box' ? 'selected' : '' }}>Box</option>
                            <option value="Tablet" {{ $obat->satuan == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" style="display: flex; gap: 1rem;">
                    <div style="flex: 1;">
                        <label class="form-label">Harga Jual (Rp)</label>
                        <input type="number" name="harga" class="form-control" value="{{ $obat->harga }}" required>
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label">Tanggal Kadaluarsa</label>
                        <input type="date" name="expired_date" class="form-control" value="{{ $obat->expired_date }}"
                            required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Gambar Obat</label>
                    <input type="file" name="gambar" class="form-control">
                    @if($obat->gambar)
                        <img src="/images/obat/{{ $obat->gambar }}" width="100px"
                            style="margin-top: 10px; border-radius: 6px;">
                    @endif
                </div>

                <button type="submit" class="btn-submit">Update Data</button>
            </form>
        </div>
    </main>
</body>

</html>