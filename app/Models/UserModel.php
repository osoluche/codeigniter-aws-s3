<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'username', 
        'email', 
        'password', 
        'role', 
        'is_active', 
        'last_login'
    ];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    public function validateUser($username, $password)
    {
        $user = $this->where('username', $username)->first();
        
        if ($user && !$user['is_active']) {
            return false; // User is blocked
        }

        return $user && password_verify($password, $user['password']) ? $user : false;
    }
}