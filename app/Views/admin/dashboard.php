<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - AeroServe</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50">
    <nav class="bg-slate-800 text-white shadow-md px-6 py-4 mb-8">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">AeroServe Admin</h1>
            <div class="space-x-4 text-sm font-semibold flex items-center">
                <a href="<?= base_url('admin/dashboard') ?>" class="text-blue-400">Layanan</a>
                <a href="<?= base_url('admin/schedules') ?>" class="hover:text-blue-300 transition">Jadwal</a>
                <a href="<?= base_url('admin/bookings') ?>" class="hover:text-blue-300 transition">Reservasi</a>
                <a href="<?= base_url('admin/teknisi') ?>" class="hover:text-blue-300 transition">Mekanik</a>
                
                <span class="ml-4 pl-4 border-l border-slate-600 text-amber-400 font-normal">Halo, <?= esc(session()->get('name')) ?>!</span>
                <a href="<?= base_url('logout') ?>" class="bg-red-500 hover:bg-red-600 px-5 py-2 rounded-full text-sm font-bold transition shadow-sm transform hover:-translate-y-0.5">Logout</a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                <p><?= session()->getFlashdata('success') ?></p>
            </div>
        <?php endif; ?>

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Kelola Layanan Bengkel</h2>
            <a href="<?= base_url('admin/services/create') ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition shadow-sm">
                + Tambah Layanan Baru
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php foreach ($services as $service): ?>
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                    <?php if (!empty($service['foto'])): ?>
                        <img src="<?= base_url('uploads/services/' . $service['foto']) ?>" alt="<?= $service['nama_layanan'] ?>" class="w-full h-48 object-cover">
                    <?php else: ?>
                        <div class="w-full h-48 bg-slate-200 flex items-center justify-center text-slate-400">Tanpa Foto</div>
                    <?php endif; ?>

                    <div class="p-5">
                        <h3 class="font-bold text-lg text-slate-800"><?= esc($service['nama_layanan']) ?></h3>
                        <p class="text-slate-500 text-sm mt-1 mb-4 h-10 overflow-hidden"><?= esc($service['deskripsi']) ?></p>

                        <div class="flex justify-between items-center border-t border-slate-100 pt-4">
                            <div>
                                <p class="font-bold text-blue-600">Rp <?= number_format($service['harga'], 0, ',', '.') ?></p>
                                <p class="text-xs text-slate-400">⏱ <?= $service['estimasi_waktu'] ?> Menit</p>
                            </div>
                            <div class="flex gap-2">
                                <div class="flex gap-2">
                                    <a href="<?= base_url('admin/services/edit/' . $service['id']) ?>"
                                        class="bg-amber-400 hover:bg-amber-500 text-white px-3 py-1 rounded text-sm transition text-center font-bold">
                                        Edit
                                    </a>

                                    <a href="<?= base_url('admin/services/delete/' . $service['id']) ?>"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus layanan ini? Foto akan ikut terhapus dari sistem.');"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition text-center font-bold">
                                        Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>

</html>