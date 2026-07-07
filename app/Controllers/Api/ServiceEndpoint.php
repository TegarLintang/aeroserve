<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ServiceModel;

class ServiceEndpoint extends ResourceController
{
    protected $modelName = 'App\Models\ServiceModel';
    protected $format    = 'json';

    public function index()
    {
        $services = $this->model->findAll();
    
        if ($services) {
            return $this->respond([
                'status'  => true,
                'message' => 'Data layanan berhasil diambil',
                'data'    => $services
            ], 200);
        } else {
            return $this->failNotFound('Tidak ada data layanan ditemukan.');
        }
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        
        if ($data) {
            return $this->respond([
                'status'  => true,
                'message' => 'Detail layanan ditemukan',
                'data'    => $data
            ], 200);
        } else {
            return $this->failNotFound('Layanan dengan ID ' . $id . ' tidak ditemukan.');
        }
    }
}

// http://localhost:8080/api/services?key=AEROSERVE-API-12345
// http://localhost:8080/api/services/1?key=AEROSERVE-API-12345