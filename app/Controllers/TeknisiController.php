<?php namespace App\Controllers;

use App\Models\BookingModel;

class TeknisiController extends BaseController
{
    protected $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
    }

    public function index()
    {
        $teknisiId = session()->get('id'); 

        $data = [
            'title'    => 'Antrean Tugas Mekanik - AeroServe',
            'bookings' => $this->bookingModel->getBookings(null, $teknisiId) 
        ];
        
        return view('teknisi/jadwal', $data);
    }

    public function updateStatus($id, $status)
    {
        $booking = $this->bookingModel->find($id);
        
        if ($booking && in_array($status, ['proses', 'selesai'])) {
            $this->bookingModel->update($id, ['status' => $status]);
            session()->setFlashdata('success', 'Status pengerjaan kendaraan berhasil diubah menjadi: ' . strtoupper($status));
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui status pengerjaan.');
        }

        return redirect()->to('/teknisi/jadwal');
    }
}