<?php

namespace App\Models;

use CodeIgniter\Model;

class FileModel extends Model
{
    protected $table = 'files';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    protected $allowedFields = [
        'filename',
        's3_url',
        'user_id',
        'original_name',
        'file_size',
        'mime_type'
    ];
    
    protected $validationRules = [
        'filename'     => 'required|min_length[3]|max_length[255]',
        's3_url'      => 'required|valid_url',
        'user_id'     => 'required|integer',
        'original_name'=> 'required|min_length[1]|max_length[255]',
        'file_size'   => 'required|integer',
        'mime_type'   => 'required|min_length[1]|max_length[100]'
    ];
    
    public function getFilesByUser($userId, $limit = 10, $offset = 0)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit, $offset);
    }
    
    public function getAllFiles($limit = 10, $offset = 0)
    {
        return $this->select('files.*, users.username')
                    ->join('users', 'users.id = files.user_id')
                    ->orderBy('files.created_at', 'DESC')
                    ->findAll($limit, $offset);
    }
}