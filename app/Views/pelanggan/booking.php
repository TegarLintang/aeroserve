<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Riwayat Reservasi - AeroServe' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen">
    
    <nav class="bg-blue-700 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-xl font-extrabold tracking-tight"><a href="<?= base_url('pelanggan/booking') ?>" class="hover:text-blue-200 transition">AeroServe Bengkel</a></h1>
            <div class="flex items-center gap-5">
                <span class="text-sm font-medium">Hai, <strong class="text-blue-200 font-bold"><?= esc(session()->get('name')) ?></strong></span>
                <a href="<?= base_url('logout') ?>" class="bg-red-500 hover:bg-red-600 px-5 py-2 rounded-full text-sm font-bold transition shadow-sm transform hover:-translate-y-0.5">Logout</a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg shadow-sm font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <p><?= session()->getFlashdata('success') ?></p>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg shadow-sm font-medium flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                <p><?= session()->getFlashdata('error') ?></p>
            </div>
        <?php endif; ?>

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-800">Riwayat Reservasi Servis</h2>
                <p class="text-sm text-slate-500 mt-1">Pantau jadwal, status pengerjaan, dan tagihan kendaraan Anda di sini.</p>
            </div>

            <a href="<?= base_url('pelanggan/booking/create') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-full font-bold transition shadow-md transform hover:-translate-y-0.5 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Booking Servis Baru
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 font-bold text-xs uppercase tracking-wider border-b border-slate-200">
                            <th class="p-5">Jenis Layanan</th>
                            <th class="p-5">Jadwal Kedatangan</th>
                            <th class="p-5">Estimasi Biaya</th>
                            <th class="p-5">Status Servis</th>
                            <th class="p-5 text-center">Aksi & Tagihan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600 text-sm">
                        <?php if (empty($bookings)): ?>
                            <tr>
                                <td colspan="5" class="p-10 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        <span class="font-medium">Anda belum memiliki riwayat pemesanan servis kendaraan.</span>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($bookings as $b): ?>
                                <tr class="hover:bg-slate-50/80 transition duration-150">
                                    <td class="p-5">
                                        <p class="font-bold text-blue-700 text-base"><?= esc($b['nama_layanan']) ?></p>
                                        <?php if(!empty($b['catatan'])): ?>
                                            <p class="text-xs text-slate-500 mt-1.5 bg-slate-100 px-2.5 py-1.5 rounded-md inline-block border border-slate-200">
                                                <span class="font-semibold text-slate-600">Keluhan:</span> <?= esc($b['catatan']) ?>
                                            </p>
                                        <?php endif; ?>
                                        
                                        <!-- BAGIAN BARU: INFO MEKANIK -->
                                        <div class="mt-2">
                                            <?php if(!empty($b['nama_mekanik'])): ?>
                                                <p class="text-xs text-slate-600 bg-blue-50 inline-block px-2 py-1 rounded border border-blue-100">
                                                    👨‍🔧 Mekanik: <span class="font-bold text-blue-700"><?= esc($b['nama_mekanik']) ?></span>
                                                </p>
                                            <?php else: ?>
                                                <p class="text-xs text-amber-600 bg-amber-50 inline-block px-2 py-1 rounded border border-amber-100">
                                                    ⏳ Mekanik belum dialokasikan
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    
                                    <td class="p-5 whitespace-nowrap">
                                        <p class="font-bold text-slate-700"><?= date('d F Y', strtotime($b['tanggal'])) ?></p>
                                        <p class="text-xs font-medium text-slate-500 mt-0.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Pukul <?= date('H:i', strtotime($b['waktu'])) ?> WIB
                                        </p>
                                    </td>
                                    
                                    <td class="p-5 whitespace-nowrap">
                                        <p class="font-bold text-slate-800 text-base">Rp <?= number_format($b['harga'] ?? 0, 0, ',', '.') ?></p>
                                        <?php if (($b['payment_status'] ?? '') == 'success'): ?>
                                            <span class="text-green-600 text-xs font-bold mt-1 flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Lunas
                                            </span>
                                        <?php elseif ($b['status'] != 'batal'): ?>
                                            <span class="text-red-500 text-xs font-bold mt-1 flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Belum Dibayar
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="p-5 whitespace-nowrap">
                                        <?php if ($b['status'] == 'pending'): ?>
                                            <span class="bg-amber-100 text-amber-700 px-3 py-1.5 rounded-full text-xs font-bold border border-amber-200 inline-flex items-center gap-1.5">
                                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span> Menunggu
                                            </span>
                                        <?php elseif ($b['status'] == 'dikonfirmasi'): ?>
                                            <span class="bg-indigo-100 text-indigo-700 px-3 py-1.5 rounded-full text-xs font-bold border border-indigo-200">Dikonfirmasi</span>
                                        <?php elseif ($b['status'] == 'proses'): ?>
                                            <span class="bg-blue-100 text-blue-700 px-3 py-1.5 rounded-full text-xs font-bold border border-blue-200">🔧 Diproses</span>
                                        <?php elseif ($b['status'] == 'selesai'): ?>
                                            <span class="bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-xs font-bold border border-green-200">✅ Selesai</span>
                                        <?php else: ?>
                                            <span class="bg-red-100 text-red-700 px-3 py-1.5 rounded-full text-xs font-bold border border-red-200">✖ Dibatalkan</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="p-5 text-center flex flex-col items-center justify-center gap-2">
                                        <?php if ((($b['payment_status'] ?? '') == 'pending' || empty($b['payment_status'])) && $b['status'] != 'batal'): ?>
                                            <a href="<?= base_url('pelanggan/payment/' . $b['id']) ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-2 rounded-full transition shadow-sm w-full text-center block">
                                                💳 Bayar Tagihan
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($b['status'] == 'pending'): ?>
                                            <a href="<?= base_url('pelanggan/booking/cancel/' . $b['id']) ?>"
                                                onclick="return confirm('Apakah Anda yakin ingin membatalkan booking ini?');"
                                                class="text-red-500 hover:text-white font-bold text-xs border border-red-200 hover:bg-red-500 px-4 py-1.5 rounded-full transition duration-200 w-full text-center block">
                                                Batalkan
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($b['status'] == 'selesai' && $b['payment_status'] == 'success'): ?>
                                            <span class="text-green-600 text-xs font-bold">Transaksi Selesai</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>