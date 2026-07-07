<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table            = 'bookings';
    protected $primaryKey       = 'id';
    
    protected $allowedFields    = ['user_id', 'teknisi_id', 'service_id', 'schedule_id', 'status', 'catatan', 'snap_token', 'payment_status', 'payment_type'];
    protected $useTimestamps    = true;

    public function getBookings($userId = null, $teknisiId = null)
    {
        $builder = $this->db->table($this->table)
            ->select('
                bookings.*, 
                pelanggan.name as nama_pelanggan, 
                teknisi.name as nama_mekanik, 
                services.nama_layanan, 
                services.harga, 
                schedules.tanggal, 
                schedules.waktu
            ')
            ->join('users as pelanggan', 'pelanggan.id = bookings.user_id', 'left')
            ->join('users as teknisi', 'teknisi.id = bookings.teknisi_id', 'left')
            ->join('services', 'services.id = bookings.service_id', 'left')
            ->join('schedules', 'schedules.id = bookings.schedule_id', 'left');

        if ($userId) {
            $builder->where('bookings.user_id', $userId);
        }
        
        if ($teknisiId) {
            $builder->where('bookings.teknisi_id', $teknisiId);
        }

        $builder->orderBy('schedules.tanggal', 'DESC');
        $builder->orderBy('schedules.waktu', 'ASC');
        
        return $builder->get()->getResultArray();
    }
}