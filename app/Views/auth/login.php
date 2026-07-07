<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AeroServe</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-600">AeroServe</h1>
            <p class="text-slate-500 mt-2">Sistem Layanan Bengkel Terpadu</p>
        </div>

        <!-- Notifikasi Error -->
        <?php if(session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                <p><?= session()->getFlashdata('error') ?></p>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('loginProcess') ?>" method="post" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Alamat Email</label>
                <input type="email" name="email" required 
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" 
                    placeholder="nama@email.com">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                <input type="password" name="password" required 
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" 
                    placeholder="••••••••">
            </div>

            <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition duration-200">
                Login
            </button>
            <a href="<?= base_url('register') ?>" class="block text-center text-sm text-blue-600 hover:underline mt-4">
                Belum punya akun? Daftar di sini
            </a>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-200 text-sm text-slate-500">
            <p class="font-semibold mb-2">Akses Demo:</p>
            <ul class="space-y-1">
                <li><span class="inline-block w-16 text-slate-700">Admin</span>: admin@gmail.com (admin123)</li>
                <li><span class="inline-block w-16 text-slate-700">Teknisi</span>: teknisi@gmail.com (teknisi123)</li>
                <li><span class="inline-block w-16 text-slate-700">Pelanggan</span>: user@gmail.com (user123)</li>
            </ul>
        </div>
    </div>

</body>
</html>