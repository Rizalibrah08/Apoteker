<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pengaturan - Zapotek</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <style>
        .settings-grid {
            display: grid;
            grid-template-columns: 3fr 2fr;
            gap: 1.5rem;
        }

        .settings-card {
            background: #fff;
            padding: 2rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
        }

        .settings-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .settings-header h3 {
            font-size: 1.1rem;
            color: var(--text-main);
            margin-bottom: 0.3rem;
        }

        .settings-header p {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-main);
        }

        .form-control {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.95rem;
            outline: none;
            transition: border 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary);
        }

        .btn-save {
            background: var(--primary);
            color: #fff;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-save:hover {
            background: var(--primary-dark);
        }

        .logo-preview-container {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .logo-preview {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f0f2f5;
        }

        .btn-upload {
            background: #fff;
            border: 1px solid var(--border-color);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            color: var(--text-main);
        }

        /* Mobile */
        @media (max-width: 900px) {
            .settings-grid {
                grid-template-columns: 1fr;
            }
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
                <h2>Pengaturan Sistem</h2>
                <div style="font-size: 0.85rem; color: var(--text-muted);">
                    Konfigurasi profil apotek dan akun pengguna
                </div>
            </div>
        </div>

        <div class="settings-grid">

            @if(Auth::user()->role == 'admin')
                <!-- Left: Pharmacy Profile -->
                <div class="settings-card">
                    <div class="settings-header">
                        <h3>Profil Apotek</h3>
                        <p>Informasi yang akan tampil pada struk belanja.</p>
                    </div>

                    <form>
                        <div class="logo-preview-container">
                            <img src="{{ asset('img/logo-zapotek.jpg') }}" alt="Logo" class="logo-preview">
                            <div>
                                <button type="button" class="btn-upload">Ganti Logo</button>
                                <p style="margin-top: 5px; font-size: 0.75rem; color: var(--text-muted);">Format: JPG, PNG.
                                    Max 2MB.</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Nama Apotek</label>
                            <input type="text" class="form-control" value="Zapotek Pharmacy">
                        </div>

                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea class="form-control" rows="3">Jl. Kesehatan No. 123, Jakarta Selatan</textarea>
                        </div>

                        <div class="form-group row" style="display: flex; gap: 1rem;">
                            <div style="flex: 1;">
                                <label>No. Telepon / WhatsApp</label>
                                <input type="text" class="form-control" value="0812-3456-7890">
                            </div>
                            <div style="flex: 1;">
                                <label>Pajak / PPN (%)</label>
                                <input type="number" class="form-control" value="0">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Catatan Kaki Struk</label>
                            <input type="text" class="form-control" value="Terima kasih, semoga lekas sembuh!">
                        </div>

                        <div style="text-align: right;">
                            <button type="submit" class="btn-save">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Right: Account & Preferences -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <!-- Account Security -->
                <div class="settings-card">
                    <div class="settings-header">
                        <h3>Keamanan Akun</h3>
                        <p>Update password untuk keamanan.</p>
                    </div>
                    <form>
                        <div class="form-group">
                            <label>Password Saat Ini</label>
                            <input type="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password Baru</label>
                            <input type="password" class="form-control">
                        </div>
                        <button type="submit" class="btn-save" style="width: 100%;">Ganti Password</button>
                    </form>
                </div>

                @if(Auth::user()->role == 'admin')
                    <!-- Printer/System Prefs -->
                    <div class="settings-card">
                        <div class="settings-header">
                            <h3>Preferensi Hardware</h3>
                        </div>
                        <div class="form-group">
                            <label>Printer Struk Utama</label>
                            <select class="form-control">
                                <option>Thermal Printer 58mm (USB)</option>
                                <option>Thermal Printer 80mm (Network)</option>
                                <option>Microsoft Print to PDF</option>
                            </select>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <input type="checkbox" id="autoPrint" checked style="width: 18px; height: 18px;">
                            <label for="autoPrint" style="margin: 0;">Otomatis cetak struk setelah bayar</label>
                        </div>
                    </div>
                @endif
            </div>

        </div>

    </main>

</body>

</html>