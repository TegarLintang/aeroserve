<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'       => 'Admin',
                'email'      => 'admin@gmail.com',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Teknisi',
                'email'      => 'teknisi@gmail.com',
                'password'   => password_hash('teknisi123', PASSWORD_DEFAULT),
                'role'       => 'teknisi',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Pelanggan', 
                'email' => 'user@gmail.com',
                'password' => password_hash('user123', PASSWORD_DEFAULT),
                'role' => 'pelanggan', 
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('users')->insertBatch($data);
    }
}