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
        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-edit {
            background: rgba(74, 144, 226, 0.1);
            color: var(--primary);
        }

        .btn-edit:hover {
            background: var(--primary);
            color: #fff;
        }

        .btn-delete {
            background: rgba(231, 76, 60, 0.1);
            color: var(--danger);
        }

        .btn-delete:hover {
            background: var(--danger);
            color: #fff;
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
    @include('sidebar.index')

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
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Cari obat, kode, atau kategori...">
                </div>
                <div style="display: flex; gap: 10px;">
                    <select class="filter-select">
                        <option value="">Semua Kategori</option>
                        <option value="obat_bebas">Obat Bebas</option>
                        <option value="obat_keras">Obat Keras</option>
                        <option value="alkes">Alat Kesehatan</option>
                    </select>
                    <a href="#" class="btn-add">
                        <i class="fas fa-plus"></i> Tambah Obat
                    </a>
                </div>
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
                        <!-- Row 1 -->
                        <tr>
                            <td>1</td>
                            <td>
                                <div class="img-thumbnail">
                                    <i class="fas fa-capsules"></i>
                                </div>
                            </td>
                            <td>OBT-001</td>
                            <td>Paracetamol 500mg</td>
                            <td>Obat Bebas</td>
                            <td><span class="badge badge-success">120</span></td>
                            <td>Strip</td>
                            <td>Rp 5.000</td>
                            <td>2026-12-31</td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    <button class="action-btn btn-edit" title="Edit"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="action-btn btn-delete" title="Hapus"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <!-- Row 2 -->
                        <tr>
                            <td>2</td>
                            <td>
                                <div class="img-thumbnail">
                                    <i class="fas fa-prescription-bottle-alt"></i>
                                </div>
                            </td>
                            <td>OBT-002</td>
                            <td>Amoxicillin 500mg</td>
                            <td>Antibiotik</td>
                            <td><span class="badge badge-warning">45</span></td>
                            <td>Strip</td>
                            <td>Rp 12.000</td>
                            <td>2025-08-15</td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    <button class="action-btn btn-edit"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn btn-delete"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <!-- Row 3: Critical Stock -->
                        <tr>
                            <td>3</td>
                            <td>
                                <div class="img-thumbnail">
                                    <i class="fas fa-pills"></i>
                                </div>
                            </td>
                            <td>OBT-003</td>
                            <td>Bodrex Migra</td>
                            <td>Obat Bebas</td>
                            <td><span class="badge badge-danger">2</span></td>
                            <td>Strip</td>
                            <td>Rp 3.500</td>
                            <td>2027-01-20</td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    <button class="action-btn btn-edit"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn btn-delete"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <!-- Row 4 -->
                        <tr>
                            <td>4</td>
                            <td>
                                <div class="img-thumbnail">
                                    <i class="fas fa-syringe"></i>
                                </div>
                            </td>
                            <td>ALK-001</td>
                            <td>Spuit 3cc</td>
                            <td>Alat Kesehatan</td>
                            <td><span class="badge badge-danger">5</span></td>
                            <td>Pcs</td>
                            <td>Rp 2.000</td>
                            <td>2028-05-10</td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    <button class="action-btn btn-edit"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn btn-delete"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <!-- Row 5 -->
                        <tr>
                            <td>5</td>
                            <td>
                                <div class="img-thumbnail">
                                    <i class="fas fa-prescription-bottle"></i>
                                </div>
                            </td>
                            <td>OBT-004</td>
                            <td>Sirup OBH</td>
                            <td>Obat Batuk</td>
                            <td><span class="badge badge-danger">1</span></td>
                            <td>Botol</td>
                            <td>Rp 15.000</td>
                            <td>2025-03-01</td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    <button class="action-btn btn-edit"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn btn-delete"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
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