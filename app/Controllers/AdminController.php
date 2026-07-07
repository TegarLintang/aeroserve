<?php namespace App\Controllers;

use App\Models\ServiceModel;
use App\Models\BookingModel;
use App\Models\UserModel;

class AdminController extends BaseController 
{
    protected $serviceModel;
    protected $bookingModel;
    protected $userModel;
    

    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
        $this->bookingModel = new BookingModel();
        $this->userModel    = new UserModel();
    }

    public function index() 
    { 
        $data = [
            'title'    => 'Dashboard Admin - AeroServe',
            'services' => $this->serviceModel->findAll()
            
        ];
        return view('admin/dashboard', $data); 
    }

    public function createService()
    {
        return view('admin/create_service');
    }

    public function storeService()
    {
        if (!$this->validate([
            'nama_layanan'   => 'required|min_length[3]',
            'harga'          => 'required|numeric',
            'estimasi_waktu' => 'required|numeric',
            'foto'           => 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileFoto = $this->request->getFile('foto');
        $namaFoto = $fileFoto->getRandomName();
        $fileFoto->move('uploads/services', $namaFoto);

        $this->serviceModel->save([
            'nama_layanan'   => $this->request->getPost('nama_layanan'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'harga'          => $this->request->getPost('harga'),
            'estimasi_waktu' => $this->request->getPost('estimasi_waktu'),
            'foto'           => $namaFoto
        ]);

        session()->setFlashdata('success', 'Layanan bengkel berhasil ditambahkan!');
        return redirect()->to('/admin/dashboard');
    }

    public function editService($id)
    {
        $data = [
            'title'   => 'Edit Layanan - AeroServe',
            'service' => $this->serviceModel->find($id)
        ];
        return view('admin/edit_service', $data);
    }

    public function updateService($id)
    {
        $serviceLama = $this->serviceModel->find($id);

        $rules = [
            'nama_layanan'   => 'required|min_length[3]',
            'harga'          => 'required|numeric',
            'estimasi_waktu' => 'required|numeric',
        ];

        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto->getError() != 4) { 
            $rules['foto'] = 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $namaFotoBaru = $serviceLama['foto'];

        if ($fileFoto->getError() != 4) {
            $namaFotoBaru = $fileFoto->getRandomName();
            $fileFoto->move('uploads/services', $namaFotoBaru);
            
            if (!empty($serviceLama['foto']) && file_exists('uploads/services/' . $serviceLama['foto'])) {
                unlink('uploads/services/' . $serviceLama['foto']);
            }
        }

        $this->serviceModel->update($id, [
            'nama_layanan'   => $this->request->getPost('nama_layanan'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'harga'          => $this->request->getPost('harga'),
            'estimasi_waktu' => $this->request->getPost('estimasi_waktu'),
            'foto'           => $namaFotoBaru
        ]);

        session()->setFlashdata('success', 'Data layanan berhasil diperbarui!');
        return redirect()->to('/admin/dashboard');
    }

    public function deleteService($id)
    {
        $service = $this->serviceModel->find($id);
        
        if (!empty($service['foto']) && file_exists('uploads/services/' . $service['foto'])) {
            unlink('uploads/services/' . $service['foto']);
        }
        
        $this->serviceModel->delete($id);
        
        session()->setFlashdata('success', 'Layanan beserta fotonya berhasil dihapus!');
        return redirect()->to('/admin/dashboard');
    }

    public function bookings()
    {
        $data = [
            'title'    => 'Kelola Reservasi Pelanggan - AeroServe',
            'bookings' => $this->bookingModel->getBookings(), 
            'teknisi'  => $this->userModel->where('role', 'teknisi')->findAll() 
        ];
        return view('admin/bookings', $data);
    }

    public function confirmBooking($id)
    {
        $status = $this->request->getPost('status'); // 'dikonfirmasi' atau 'batal'
        $updateData = ['status' => $status];
        
        if ($status == 'dikonfirmasi') {
            $updateData['teknisi_id'] = $this->request->getPost('teknisi_id');
        }

        $this->bookingModel->update($id, $updateData);
        session()->setFlashdata('success', 'Status reservasi berhasil diperbarui!');
        return redirect()->to('/admin/bookings');
    }

    public function teknisi()
    {
        $data = [
            'title'   => 'Kelola Staff Mekanik - AeroServe',
            'teknisi' => $this->userModel->where('role', 'teknisi')->findAll()
        ];
        return view('admin/teknisi', $data);
    }

    public function storeTeknisi()
    {
        if (!$this->validate([
            'name'     => 'required|min_length[3]|max_length[50]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->save([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'     => 'teknisi' 
        ]);

        session()->setFlashdata('success', 'Akun mekanik baru berhasil ditambahkan!');
        return redirect()->to('/admin/teknisi');
    }

    public function deleteTeknisi($id)
    {
        $this->userModel->delete($id);
        session()->setFlashdata('success', 'Akun mekanik berhasil dihapus dari sistem!');
        return redirect()->to('/admin/teknisi');
    }
}