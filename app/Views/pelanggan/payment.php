<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran AeroServe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $clientKey ?>"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200 w-full max-w-sm text-center">
        <h2 class="text-xl font-bold mb-4">Selesaikan Pembayaran</h2>
        <p class="text-slate-500 mb-6">Total: <strong>Rp <?= number_format($service['harga'], 0, ',', '.') ?></strong></p>
        
        <button id="pay-button" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700">
            Bayar Sekarang
        </button>
    </div>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function () {
            snap.pay('<?= $snapToken ?>', {
                onSuccess: function(result){
                    window.location.href = "<?= base_url('pelanggan/payment/success/' . $booking['id']) ?>";
                },
                onPending: function(result){
                    window.location.href = "<?= base_url('pelanggan/booking') ?>";
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                }
            });
        };
    </script>
</body>
</html>