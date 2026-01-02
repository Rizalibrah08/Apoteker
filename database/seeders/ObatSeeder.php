<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Obat::create([
            'kode_obat' => 'OBT-001',
            'nama_obat' => 'Paracetamol 500mg',
            'kategori' => 'Obat Bebas',
            'stok' => 120,
            'satuan' => 'Strip',
            'harga' => 5000,
            'expired_date' => '2026-12-31',
        ]);

        \App\Models\Obat::create([
            'kode_obat' => 'OBT-002',
            'nama_obat' => 'Amoxicillin 500mg',
            'kategori' => 'Antibiotik',
            'stok' => 45,
            'satuan' => 'Strip',
            'harga' => 12000,
            'expired_date' => '2025-08-15',
        ]);

        \App\Models\Obat::create([
            'kode_obat' => 'OBT-003',
            'nama_obat' => 'Bodrex Migra',
            'kategori' => 'Obat Bebas',
            'stok' => 50,
            'satuan' => 'Strip',
            'harga' => 3500,
            'expired_date' => '2027-01-20',
        ]);

        \App\Models\Obat::create([
            'kode_obat' => 'OBT-004',
            'nama_obat' => 'Sirup OBH',
            'kategori' => 'Obat Batuk',
            'stok' => 10,
            'satuan' => 'Botol',
            'harga' => 15000,
            'expired_date' => '2025-03-01',
        ]);
    }
}
