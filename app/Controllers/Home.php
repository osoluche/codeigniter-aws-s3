<?php

namespace App\Controllers;
use App\Models\FileModel;
use App\Models\UserModel;

class Home extends BaseController
{
    protected $fileModel;
    protected $userModel;

    public function __construct()
    {
        $this->fileModel = new FileModel();
        $this->userModel = new UserModel();
    }

    public function index(): string
    {
        return view('welcome_message');
    }

    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function dashboard()
    {
        $userId = session()->get('user_id');
        $isAdmin = session()->get('role') === 'admin';

        $data = [
            'files' => $isAdmin ? $this->fileModel->getAllFiles(10, 0) : $this->fileModel->getFilesByUser($userId, 10, 0),
            'user' => $this->userModel->find($userId)
        ];

        return view('dashboard', $data);
    }
}
