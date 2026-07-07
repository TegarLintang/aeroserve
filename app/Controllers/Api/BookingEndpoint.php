<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\BookingModel;

class BookingEndpoint extends ResourceController
{
    protected $format = 'json';

    public function status($id = null)
    {
        $bookingModel = new BookingModel();
        
        $booking = $bookingModel->find($id);
        
        if ($booking) {
            return $this->respond([
                'status'  => true,
                'message' => 'Status booking berhasil diambil',
                'data'    => [
                    'id_booking'        => $booking['id'],
                    'id_pelanggan'      => $booking['user_id'],
                    'status_pengerjaan' => $booking['status'],
                    'status_pembayaran' => $booking['payment_status'] ?? 'pending',
                    'catatan'           => $booking['catatan']
                ]
            ], 200);
        } else {
            return $this->failNotFound('Data booking dengan ID tersebut tidak ditemukan.');
        }
    }
}

// http://localhost:8080/api/booking-status/9?key=AEROSERVE-API-12345