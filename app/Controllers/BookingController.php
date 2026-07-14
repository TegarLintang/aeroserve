<?php namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\ServiceModel;
use App\Models\ScheduleModel;

class BookingController extends BaseController
{
    protected $bookingModel;
    protected $serviceModel;
    protected $scheduleModel; 

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->serviceModel = new ServiceModel();
        $this->scheduleModel = new ScheduleModel();
    }
    
    public function index()
{
    $userId = session()->get('id');
    $bookings = $this->bookingModel->getBookings($userId);

    $cache = \Config\Services::cache();

    foreach ($bookings as &$b) {
        if ($b['payment_status'] == 'pending' && !empty($b['snap_token'])) {
            try {
                \Midtrans\Config::$serverKey = 'Mid-server-xrCrty7cPSwvhJg-wE_Dlx7K';
                \Midtrans\Config::$isProduction = false;
                $status = \Midtrans\Transaction::status('AERO-' . $b['id']);
                if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                    $this->bookingModel->update($b['id'], ['payment_status' => 'success']);
                    $b['payment_status'] = 'success';
                }
            } catch (\Exception $e) {
                continue; 
            }
        }
    }

    $data = [
        'title'       => 'Riwayat Reservasi - AeroServe',
        'bookings'    => $bookings,
    ];
    
        return view('pelanggan/booking', $data);
    }

    public function create()
    {
        $services = $this->serviceModel->findAll();
        
        $rawSchedules = $this->scheduleModel->where('tanggal >=', date('Y-m-d'))
                                            ->orderBy('tanggal', 'ASC')
                                            ->orderBy('waktu', 'ASC')
                                            ->findAll();

        $schedules = [];
        foreach ($rawSchedules as $jadwal) {
            $terisi = $this->bookingModel->where('schedule_id', $jadwal['id'])
                                         ->where('status !=', 'batal')
                                         ->countAllResults();
            $jadwal['sisa_slot'] = $jadwal['kapasitas'] - $terisi;
            $schedules[] = $jadwal;
        }

        $data = [
            'title'     => 'Pesan Layanan Bengkel Baru - AeroServe',
            'services'  => $services,
            'schedules' => $schedules 
        ];
        
        return view('pelanggan/create_booking', $data);
    }

    public function store()
    {
        // 1. Validasi input dasar
        if (!$this->validate([
            'service_id'  => 'required',
            'schedule_id' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $scheduleId = $this->request->getPost('schedule_id');
        $jadwal = $this->scheduleModel->find($scheduleId);
        $jumlahBookingSaatIni = $this->bookingModel->where('schedule_id', $scheduleId)
                                                   ->where('status !=', 'batal')
                                                   ->countAllResults();

        if ($jumlahBookingSaatIni >= $jadwal['kapasitas']) {
            return redirect()->back()->withInput()->with('errors', [
                'Maaf, slot jadwal pada tanggal/waktu tersebut sudah penuh! Silakan pilih jadwal lain.'
            ]);
        }

        $serviceId = $this->request->getPost('service_id');
        $layanan = $this->serviceModel->find($serviceId);
        $namaLayanan = $layanan ? $layanan['nama_layanan'] : 'Tidak diketahui';

        $this->bookingModel->save([
            'user_id'     => session()->get('id'),
            'service_id'  => $this->request->getPost('service_id'),
            'schedule_id' => $scheduleId, 
            'catatan'     => $this->request->getPost('catatan'),
            'status'      => 'pending' 
        ]);

        try {
            $client = \Config\Services::curlrequest();
            
            $botToken = '8778278813:AAFmt5EJGHvRqpPCjV5prgJcdEr6CI6fXBQ'; 
            $chatId   = '1441960042';
            
            $pesan = "🔔 *RESERVASI SERVIS BARU!*\n\n";
            $pesan .= "👤 *Pelanggan:* " . session()->get('name') . "\n";
            $pesan .= "🔧 *Layanan:* " . $namaLayanan . "\n";
            $pesan .= "📅 *Jadwal:* " . date('d M Y', strtotime($jadwal['tanggal'])) . " (" . date('H:i', strtotime($jadwal['waktu'])) . " WIB)\n";
            $pesan .= "📝 *Catatan:* " . ($this->request->getPost('catatan') ?: 'Tidak ada') . "\n\n";
            $pesan .= "Silakan login ke AdminPanel untuk konfirmasi pesanan ini.";

            $url = "https://api.telegram.org/bot{$botToken}/sendMessage";

            $client->request('POST', $url, [
                'timeout'     => 10,
                'verify'      => false,
                'form_params' => [
                    'chat_id'    => $chatId,
                    'text'       => $pesan,
                    'parse_mode' => 'Markdown'
                ]
            ]);
        } catch (\Exception $e) {
            log_message('error', 'API Notifikasi Gagal: ' . $e->getMessage());
        }
        // =====================================================================

        session()->setFlashdata('success', 'Booking servis berhasil dikirim! Menunggu konfirmasi admin.');
        return redirect()->to('/pelanggan/booking');
    }

    public function cancel($id)
    {
        $booking = $this->bookingModel->find($id);
        
        if ($booking && $booking['user_id'] == session()->get('id') && $booking['status'] == 'pending') {
            $this->bookingModel->update($id, ['status' => 'batal']);
            session()->setFlashdata('success', 'Pemesanan servis Anda telah dibatalkan.');
        } else {
            session()->setFlashdata('error', 'Gagal membatalkan pemesanan, atau status sudah dikonfirmasi.');
        }

        return redirect()->to('/pelanggan/booking');
    }
}