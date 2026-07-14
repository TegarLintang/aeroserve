# AeroServe - Sistem Pemesanan Layanan 🛠️

Aplikasi *Service Booking* berbasis web yang dibangun menggunakan CodeIgniter 4. Terintegrasi dengan notifikasi Telegram dan Payment Gateway Midtrans.

## Fitur Utama
* Multi-role Authentication (Admin, Teknisi, Pelanggan)
* Booking jadwal secara *real-time*
* Pembayaran otomatis via Midtrans Sandbox
* Notifikasi via Webservice Telegram
* RESTful API Endpoint dengan Middleware

## Persyaratan Sistem
* PHP 8.1 atau lebih baru
* MySQL / MariaDB
* Composer

## Cara Instalasi
1. Clone repositori ini: `git clone https://github.com/TegarLintang/aeroserve.git`
3. Jalankan perintah composer: `composer install`
4. Ubah nama file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database.
5. Jalankan migrasi dan seeder: `php spark migrate --seed`
6. Jalankan server lokal: `php spark serve`

## Akun Demo
* **Admin:** admin@gmail.com | Password: admin123
* **Pelanggan:** user@gmail.com | Password: user123
* **Teknisi:** teknisi@gmail.com | Password: Teknisi123
