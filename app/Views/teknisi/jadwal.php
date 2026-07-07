<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen">
    <nav class="bg-amber-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-xl font-extrabold tracking-tight">🔧 Area Mekanik AeroServe</h1>
            <div class="flex items-center gap-5">
                <span class="text-sm font-medium">Mekanik: <strong class="text-amber-200"><?= esc(session()->get('name')) ?></strong></span>
                <a href="<?= base_url('logout') ?>" class="bg-red-500 hover:bg-red-600 px-5 py-2 rounded-full text-sm font-bold transition">Logout</a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-10">
        <h2 class="text-2xl font-extrabold text-slate-800 mb-6">Antrean Tugas Saya</h2>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if(empty($bookings)): ?>
                <div class="col-span-full text-center py-10 bg-white rounded-xl shadow-sm border border-slate-200">
                    <p class="text-slate-500 font-medium">Belum ada antrean kendaraan yang ditugaskan kepada Anda.</p>
                </div>
            <?php endif; ?>

            <?php foreach ($bookings as $b): ?>
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-3">
                            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded"><?= esc($b['nama_layanan']) ?></span>
                            <span class="text-xs font-semibold text-slate-500">
                                <?= date('d M Y', strtotime($b['tanggal'])) ?> | <?= date('H:i', strtotime($b['waktu'])) ?>
                            </span>
                        </div>
                        
                        <p class="text-lg font-bold text-slate-800">👤 <?= esc($b['nama_pelanggan']) ?></p>
                        
                        <div class="mt-3 bg-slate-50 p-3 rounded-lg border border-slate-100">
                            <p class="text-xs font-bold text-slate-500 uppercase mb-1">Catatan Keluhan:</p>
                            <p class="text-sm text-slate-700 italic">"<?= esc($b['catatan'] ?: 'Tidak ada keluhan khusus') ?>"</p>
                        </div>
                    </div>
                    
                    <div class="mt-5 border-t pt-4">
                        <?php if ($b['status'] == 'dikonfirmasi'): ?>
                            <a href="<?= base_url('teknisi/booking/update-status/' . $b['id'] . '/proses') ?>" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition shadow">
                                🔧 Mulai Kerjakan
                            </a>
                        <?php elseif ($b['status'] == 'proses'): ?>
                            <a href="<?= base_url('teknisi/booking/update-status/' . $b['id'] . '/selesai') ?>" onclick="return confirm('Apakah kendaraan ini sudah selesai diperbaiki?');" class="block w-full text-center bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition shadow">
                                ✅ Selesaikan Tugas
                            </a>
                        <?php elseif ($b['status'] == 'selesai'): ?>
                            <div class="block w-full text-center bg-slate-100 text-slate-500 font-bold py-2 px-4 rounded border border-slate-200">
                                Tugas Selesai
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>