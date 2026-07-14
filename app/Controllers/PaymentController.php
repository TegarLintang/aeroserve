<?php namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\ServiceModel;
use App\Models\UserModel;

class PaymentController extends BaseController
{
    protected $bookingModel;
    protected $serviceModel;
    protected $userModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->serviceModel = new ServiceModel();
        $this->userModel    = new UserModel();

        \Midtrans\Config::$serverKey = 'Mid-server-xrCrty7cPSwvhJg-wE_Dlx7K';
        \Midtrans\Config::$clientKey = 'Mid-client-gRYbmq_oYEjMQrLk';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    public function pay($id)
    {
        $booking = $this->bookingModel->find($id);
        if (!$booking || $booking['user_id'] != session()->get('id')) {
            return redirect()->to('/pelanggan/booking')->with('error', 'Pesanan tidak ditemukan.');
        }

        $service = $this->serviceModel->find($booking['service_id']);
        $user    = $this->userModel->find($booking['user_id']);

        // Jika token belum ada, buat baru
        if (empty($booking['snap_token'])) {
            $params = [
                'transaction_details' => [
                    'order_id'     => 'AERO-' . $booking['id'] . '-' . time(),
                    'gross_amount' => (int)$service['harga'],
                ],
                'customer_details' => [
                    'first_name' => $user['name'],
                    'email'      => $user['email'],
                ],
            ];

            try {
                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $this->bookingModel->update($id, ['snap_token' => $snapToken]);
                $booking['snap_token'] = $snapToken;
            } catch (\Exception $e) {
                return redirect()->to('/pelanggan/booking')->with('error', 'Midtrans Error: ' . $e->getMessage());
            }
        }

        return view('pelanggan/payment', [
            'title'     => 'Pembayaran AeroServe',
            'booking'   => $booking,
            'service'   => $service,
            'snapToken' => $booking['snap_token'],
            'clientKey' => \Midtrans\Config::$clientKey
        ]);
    }

    public function success($id)
    {
        $this->bookingModel->update($id, ['payment_status' => 'success']);
        
        return redirect()->to('/pelanggan/booking')->with('success', 'Pembayaran berhasil dikonfirmasi oleh sistem!');
    }
}