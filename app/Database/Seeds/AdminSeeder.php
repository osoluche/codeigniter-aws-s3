<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'osoluche',
                'email'    => 'osoluche@admin.com',
                'password' => password_hash('5hUgb&1rV4', PASSWORD_DEFAULT),
                'role'     => 'admin',
                'is_active'=> 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($data as $user) {
            // Check if user already exists
            $existingUser = $this->db->table('users')
                ->where('email', $user['email'])
                ->get()
                ->getRow();

            if (!$existingUser) {
                $this->db->table('users')->insert($user);
            }
        }
    }
}