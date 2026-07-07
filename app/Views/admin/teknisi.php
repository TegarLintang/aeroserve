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
            <div class="space-x-4 text-sm font-semibold flex items-center">
                <a href="<?= base_url('admin/dashboard') ?>" class="hover:text-blue-300 transition">Layanan</a>
                <a href="<?= base_url('admin/schedules') ?>" class="hover:text-blue-300 transition">Jadwal</a>
                <a href="<?= base_url('admin/bookings') ?>" class="hover:text-blue-300 transition">Reservasi</a>
                <a href="<?= base_url('admin/teknisi') ?>" class="text-blue-400 transition">Mekanik</a>
                
                <span class="ml-4 pl-4 border-l border-slate-600 text-amber-400 font-normal">Halo, <?= esc(session()->get('name')) ?>!</span>
                <a href="<?= base_url('logout') ?>" class="bg-red-500 hover:bg-red-600 px-5 py-2 rounded-full text-sm font-bold transition shadow-sm transform hover:-translate-y-0.5">Logout</a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="md:col-span-1">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Daftarkan Mekanik Baru</h2>

                <?php if (session()->has('errors')) : ?>
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-600 p-3 rounded mb-4 text-sm">
                        <?php foreach (session('errors') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>

                <form action="<?= base_url('admin/teknisi/store') ?>" method="post" class="space-y-4">
                    <?= csrf_field() ?>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="<?= old('name') ?>" required class="w-full border-slate-300 rounded-lg p-2.5 border focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Alamat Email</label>
                        <input type="email" name="email" value="<?= old('email') ?>" required class="w-full border-slate-300 rounded-lg p-2.5 border focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="mekanik@aeroserve.com">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                        <input type="password" name="password" required class="w-full border-slate-300 rounded-lg p-2.5 border focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="Minimal 6 karakter">
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2.5 rounded-lg hover:bg-blue-700 transition">
                        Simpan Akun
                    </button>
                </form>
            </div>
        </div>

        <div class="md:col-span-2">
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Mekanik</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if(empty($teknisi)): ?>
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-500">Belum ada data mekanik yang terdaftar.</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($teknisi as $row) : ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-800">
                                    <?= esc($row['name']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                                    <?= esc($row['email']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <a href="<?= base_url('admin/teknisi/delete/' . $row['id']) ?>" class="bg-red-100 text-red-600 hover:bg-red-200 px-3 py-1.5 rounded text-xs font-bold transition" onclick="return confirm('Yakin ingin menghapus akun mekanik ini?')">Hapus Akses</a>
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