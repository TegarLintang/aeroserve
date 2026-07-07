<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Buat Reservasi Baru - AeroServe' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 min-h-screen pb-12">

    <nav class="bg-blue-700 text-white shadow-lg mb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-xl font-extrabold tracking-tight"><a href="<?= base_url('pelanggan/booking') ?>" class="hover:text-blue-200 transition">AeroServe Bengkel</a></h1>
            <div class="flex items-center gap-5">
                <a href="<?= base_url('pelanggan/booking') ?>" class="hidden sm:block text-blue-200 hover:text-white text-sm font-semibold transition">Riwayat Reservasi</a>
                <span class="text-sm font-medium border-l border-blue-500 pl-5 hidden sm:block">Hai, <strong class="text-blue-200 font-bold"><?= esc(session()->get('name')) ?></strong></span>
                <a href="<?= base_url('logout') ?>" class="bg-red-500 hover:bg-red-600 px-5 py-2 rounded-full text-sm font-bold transition shadow-sm transform hover:-translate-y-0.5">Logout</a>
            </div>
        </div>
    </nav>

    <main class="max-w-xl mx-auto px-4 sm:px-6">
        
        <div class="flex justify-between items-center mb-4 px-2">
            <a href="<?= base_url('pelanggan/booking') ?>" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center gap-1 transition">
                &larr; Kembali ke Riwayat
            </a>
        </div>

        <div class="bg-white p-8 sm:p-10 rounded-2xl shadow-sm border border-slate-200 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-indigo-600"></div>

            <div class="mb-8 text-center sm:text-left">
                <h2 class="text-2xl font-extrabold text-slate-800">Buat Reservasi Baru</h2>
                <p class="text-slate-500 text-sm mt-1.5">Pilih layanan servis dan amankan jadwal kendaraan Anda.</p>
            </div>

            <?php if (session()->has('errors')) : ?>
                <div class="bg-red-50 text-red-700 p-4 rounded-lg mb-8 text-sm border border-red-200 flex items-start shadow-sm">
                    <svg class="w-5 h-5 mr-3 shrink-0 text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                    <ul class="list-disc list-inside font-medium space-y-1">
                        <?php foreach (session('errors') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>

            <form action="<?= base_url('pelanggan/booking/store') ?>" method="post" class="space-y-6">
                <?= csrf_field() ?>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Layanan <span class="text-red-500">*</span></label>
                    <select name="service_id" required class="w-full bg-slate-50 border-slate-300 rounded-xl p-3.5 border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white outline-none transition cursor-pointer text-slate-700">
                        <option value="" disabled selected>-- Pilih Layanan Servis --</option>
                        <?php foreach ($services as $service) : ?>
                            <option value="<?= $service['id'] ?>">
                                <?= esc($service['nama_layanan']) ?> - Rp <?= number_format($service['harga'], 0, ',', '.') ?> (Est. <?= $service['estimasi_waktu'] ?> mnt)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jadwal Kedatangan <span class="text-red-500">*</span></label>
                    <select name="schedule_id" required class="w-full bg-slate-50 border-slate-300 rounded-xl p-3.5 border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white outline-none transition cursor-pointer text-slate-700">
                        <option value="" disabled selected>-- Pilih Tanggal & Waktu --</option>
                        <?php if (empty($schedules)): ?>
                            <option value="" disabled>Maaf, belum ada jadwal bengkel yang dibuka.</option>
                        <?php else: ?>
                            <?php foreach ($schedules as $schedule) : ?>
                                <option value="<?= $schedule['id'] ?>" <?= $schedule['sisa_slot'] <= 0 ? 'disabled' : '' ?> class="<?= $schedule['sisa_slot'] <= 0 ? 'bg-red-50 text-red-500 font-medium' : '' ?>">
                                    <?= date('d M Y', strtotime($schedule['tanggal'])) ?> | Pukul <?= date('H:i', strtotime($schedule['waktu'])) ?> WIB
                                    
                                    <?php if ($schedule['sisa_slot'] <= 0): ?>
                                        - (Penuh / Habis)
                                    <?php else: ?>
                                        - (Tersedia: <?= $schedule['sisa_slot'] ?> Slot)
                                    <?php endif; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Keluhan / Catatan Tambahan <span class="text-slate-400 font-normal text-xs ml-1">(Opsional)</span></label>
                    <textarea name="catatan" rows="3" class="w-full bg-slate-50 border-slate-300 rounded-xl p-3.5 border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white outline-none transition text-slate-700" placeholder="Misal: Tarikan gas berat, tolong dicek kampas gandanya..."><?= old('catatan') ?></textarea>
                </div>

                <div class="pt-6 border-t border-slate-100 mt-8">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition shadow-md transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Konfirmasi Booking Servis
                    </button>
                    <p class="text-xs text-center text-slate-400 mt-4 font-medium">Anda dapat membatalkan pesanan nanti jika jadwal berubah.</p>
                </div>
            </form>
        </div>
    </main>

</body>

</html>