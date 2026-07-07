<?php namespace App\Controllers;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login() { return view('auth/login'); }

    public function loginProcess()
    {
        $session = session();
        $userModel = new UserModel();
        $user = $userModel->where('email', $this->request->getPost('email'))->first();
        
        if ($user && password_verify($this->request->getPost('password'), $user['password'])) {
            $session->set(['id' => $user['id'], 'name' => $user['name'], 'role' => $user['role'], 'isLoggedIn' => true]);
            
            if ($user['role'] == 'admin') return redirect()->to('/admin/dashboard');
            if ($user['role'] == 'teknisi') return redirect()->to('/teknisi/jadwal');
            return redirect()->to('/pelanggan/booking');
        }
        return redirect()->to('/login')->with('error', 'Email atau Password salah!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function register()
    {
        return view('auth/register', ['title' => 'Daftar Akun - AeroServe']);
    }

    public function registerProcess()
    {
        if (!$this->validate([
            'name'     => 'required|min_length[3]|max_length[50]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'matches[password]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'     => 'pelanggan' // Paksa role menjadi pelanggan demi keamanan
        ];

        $userModel = new \App\Models\UserModel();
        $userModel->save($data);

        return redirect()->to('/login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }
}