<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_layanan'   => 'Ganti Oli Mesin',
                'deskripsi'      => 'Penggantian oli mesin standar beserta filter oli.',
                'harga'          => 150000,
                'estimasi_waktu' => 30,
                'created_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'nama_layanan'   => 'Servis Rutin Berkala',
                'deskripsi'      => 'Pengecekan rem, lampu, tekanan ban, dan pembersihan filter udara.',
                'harga'          => 250000,
                'estimasi_waktu' => 90,
                'created_at'     => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('services')->insertBatch($data);
    }
}