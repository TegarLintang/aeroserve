<?php namespace App\Controllers;

use App\Models\ScheduleModel;

class ScheduleController extends BaseController
{
    protected $scheduleModel;

    public function __construct()
    {
        $this->scheduleModel = new ScheduleModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Kelola Kapasitas Jadwal - AeroServe',
            'schedules' => $this->scheduleModel->orderBy('tanggal', 'ASC')->orderBy('waktu', 'ASC')->findAll()
        ];
        return view('admin/schedules', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'tanggal'   => 'required|valid_date',
            'waktu'     => 'required',
            'kapasitas' => 'required|numeric'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->scheduleModel->save([
            'tanggal'   => $this->request->getPost('tanggal'),
            'waktu'     => $this->request->getPost('waktu'),
            'kapasitas' => $this->request->getPost('kapasitas')
        ]);

        session()->setFlashdata('success', 'Slot jadwal baru berhasil dibuka!');
        return redirect()->to('/admin/schedules');
    }

    public function delete($id)
    {
        $this->scheduleModel->delete($id);
        session()->setFlashdata('success', 'Slot jadwal berhasil ditutup/dihapus!');
        return redirect()->to('/admin/schedules');
    }
}