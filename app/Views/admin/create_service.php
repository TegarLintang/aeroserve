<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Layanan Baru - AeroServe Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen">
    
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

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-200">
            
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-100">
                <h2 class="text-2xl font-bold text-slate-800">Tambah Layanan Baru</h2>
                <a href="<?= base_url('admin/dashboard') ?>" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center gap-1 transition">
                    &larr; Batal & Kembali
                </a>
            </div>

            <?php if(session()->getFlashdata('errors')): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded text-sm shadow-sm">
                    <ul class="list-disc ml-4 font-medium">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/services/store') ?>" method="post" enctype="multipart/form-data" class="space-y-6">
                <?= csrf_field() ?> 
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Nama Layanan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_layanan" value="<?= old('nama_layanan') ?>" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white outline-none transition" placeholder="Contoh: Servis Rutin Berkala" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Deskripsi Singkat</label>
                    <textarea name="deskripsi" rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white outline-none transition" placeholder="Tuliskan apa saja yang dilakukan dalam layanan ini..."><?= old('deskripsi') ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Harga Layanan (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="harga" value="<?= old('harga') ?>" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white outline-none transition" placeholder="Contoh: 150000" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Estimasi Waktu (Menit) <span class="text-red-500">*</span></label>
                        <input type="number" name="estimasi_waktu" value="<?= old('estimasi_waktu') ?>" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white outline-none transition" placeholder="Contoh: 45" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Upload Foto Ilustrasi <span class="text-red-500">*</span></label>
                    <input type="file" name="foto" class="w-full px-4 py-2 border border-slate-300 rounded-lg bg-slate-50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer" accept="image/*" required>
                    <p class="text-xs text-slate-400 mt-2 font-medium">Format wajib: JPG/PNG. Maksimal ukuran file: 2MB.</p>
                </div>

                <div class="pt-6 border-t border-slate-100">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-sm transition transform hover:-translate-y-0.5">
                        Simpan Layanan Baru
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>