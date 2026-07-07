<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Register' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-slate-100">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-blue-600 tracking-tight">Aero<span class="text-slate-800">Serve</span></h1>
            <p class="text-slate-500 mt-2">Buat akun untuk mulai reservasi servis motor Anda.</p>
        </div>

        <?php if (session()->has('errors')) : ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded text-sm">
                <ul>
                <?php foreach (session('errors') as $error) : ?>
                    <li>- <?= esc($error) ?></li>
                <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <form action="<?= base_url('registerProcess') ?>" method="post" class="space-y-5">
            <?= csrf_field() ?>
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="<?= old('name') ?>" class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition" placeholder="Masukkan nama Anda" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Alamat Email</label>
                <input type="email" name="email" value="<?= old('email') ?>" class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition" placeholder="email@contoh.com" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                <input type="password" name="password" class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition" placeholder="Minimal 6 karakter" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="confirm_password" class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition" placeholder="Ketik ulang password" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl transition shadow-md">
                Daftar Sekarang
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-slate-500 text-sm">Sudah punya akun? <a href="<?= base_url('login') ?>" class="text-blue-600 font-bold hover:underline">Masuk di sini</a></p>
        </div>
    </div>

</body>
</html>