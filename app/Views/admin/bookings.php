<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen">
    
    <nav class="bg-slate-800 text-white shadow-md px-6 py-4 mb-8">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">AeroServe Admin</h1>
            <div class="space-x-4 text-sm font-semibold">
                <a href="<?= base_url('admin/dashboard') ?>" class="hover:text-blue-300 transition">Layanan</a>
                <a href="<?= base_url('admin/schedules') ?>" class="hover:text-blue-300 transition">Jadwal</a>
                <a href="<?= base_url('admin/bookings') ?>" class="text-blue-400">Reservasi</a>
                <a href="<?= base_url('admin/teknisi') ?>" class="hover:text-blue-300 transition">Mekanik</a>
                
                <span class="ml-4 pl-4 border-l border-slate-600 text-amber-400 font-normal">Halo, <?= esc(session()->get('name')) ?>!</span>
                <a href="<?= base_url('logout') ?>" class="bg-red-500 hover:bg-red-600 px-5 py-2 rounded-full text-sm font-bold transition shadow-sm transform hover:-translate-y-0.5">Logout</a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Daftar Reservasi Masuk</h2>
        </div>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Layanan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Jadwal</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status & Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if(empty($bookings)): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada reservasi masuk.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($bookings as $row) : ?>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-800">
                                <span class="font-bold">👤 <?= esc($row['nama_pelanggan']) ?></span><br>
                                <span class="text-xs text-slate-400">Catatan: <?= esc($row['catatan']) ?: '-' ?></span><br>
                                
                                <span class="text-xs font-semibold text-blue-700 mt-1 inline-block bg-blue-50 px-2 py-0.5 rounded border border-blue-100">
                                    👨‍🔧 Mekanik: <?= !empty($row['nama_mekanik']) ? esc($row['nama_mekanik']) : '<span class="text-amber-500 italic">Belum ditugaskan</span>' ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600">
                                <?= esc($row['nama_layanan']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                <span class="font-bold"><?= date('d M Y', strtotime($row['tanggal'])) ?></span><br>
                                Pukul <?= date('H:i', strtotime($row['waktu'])) ?> WIB
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <?php if($row['status'] == 'pending'): ?>
                                    
                                    <form action="<?= base_url('admin/bookings/confirm/' . $row['id']) ?>" method="post" class="flex gap-2">
                                        <select name="teknisi_id" required class="border border-slate-300 rounded px-2 py-1 text-sm bg-white outline-none focus:border-blue-500">
                                            <option value="" disabled selected>-- Pilih Mekanik --</option>
                                            <?php foreach($teknisi as $t): ?>
                                                <option value="<?= $t['id'] ?>"><?= esc($t['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" name="status" value="dikonfirmasi">
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded font-bold transition">Konfirmasi</button>
                                    </form>

                                    <form action="<?= base_url('admin/bookings/confirm/' . $row['id']) ?>" method="post" class="mt-2" onsubmit="return confirm('Yakin ingin menolak reservasi ini?');">
                                        <input type="hidden" name="status" value="batal">
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-xs border border-red-200 hover:border-red-300 px-3 py-1 rounded bg-red-50 transition w-full">Tolak Pesanan</button>
                                    </form>

                                <?php else: ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide 
                                        <?= $row['status'] == 'dikonfirmasi' ? 'bg-green-100 text-green-700' : '' ?>
                                        <?= $row['status'] == 'proses' ? 'bg-blue-100 text-blue-700' : '' ?>
                                        <?= $row['status'] == 'selesai' ? 'bg-slate-200 text-slate-800' : '' ?>
                                        <?= $row['status'] == 'batal' ? 'bg-red-100 text-red-700' : '' ?>
                                    ">
                                        <?= esc($row['status']) ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>