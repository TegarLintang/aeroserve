<?php namespace App\Models;
use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table            = 'services';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama_layanan', 'deskripsi', 'harga', 'estimasi_waktu', 'foto']; 
    protected $useTimestamps    = true;
}