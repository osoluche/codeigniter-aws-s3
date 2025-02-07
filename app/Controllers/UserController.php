<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data['users'] = $this->userModel->findAll();
        return view('users/index', $data);
    }

    public function create()
    {
        if (strtolower($this->request->getMethod()) === 'post') {
            $userData = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'role' => 'employee',
                'is_active' => 1
            ];

            if ($this->userModel->insert($userData)) {
                return redirect()->to('/admin/users')->with('success', 'User created successfully');
            }

            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        return view('users/create');
    }

    public function edit($id = null)
    {
        if ($id === null) {
            return redirect()->to('/admin/users');
        }

        $data['user'] = $this->userModel->find($id);

        if (strtolower($this->request->getMethod()) === 'post') {
            $userData = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'is_active' => $this->request->getPost('is_active') ? 1 : 0
            ];

            if ($password = $this->request->getPost('password')) {
                $userData['password'] = $password;
            }

            if ($this->userModel->update($id, $userData)) {
                return redirect()->to('/admin/users')->with('success', 'User updated successfully');
            }

            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }

        return view('users/edit', $data);
    }

    public function delete($id = null)
    {
        if ($id === null) {
            return redirect()->to('/admin/users');
        }

        if ($this->userModel->delete($id)) {
            return redirect()->to('/admin/users')->with('success', 'User deleted successfully');
        }

        return redirect()->to('/admin/users')->with('error', 'Failed to delete user');
    }
}