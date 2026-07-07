<?php namespace App\Models;
use CodeIgniter\Model;

class ScheduleModel extends Model
{
    protected $table            = 'schedules';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['tanggal', 'waktu', 'kapasitas'];
    protected $useTimestamps    = true;
}