<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUser extends Model
{
    protected $table = "users";
    protected $primaryKey = "id_user";
    protected $useTimestamps = true;
    protected $allowedFields = ['email', 'username', 'password', 'role'];
    protected $useSoftDeletes = true; // Enable soft deletes
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getUser($username = false)
    {
        if ($username == false) {
            return $this->where(['users.deleted_at' => null])
                ->where("users.role !=", 'Admin')
                ->get()
                ->getResultArray();
        }

        return $this->where(['username' => $username, 'deleted_at' => null])->first();
    }

    public function getUserByBuku()
    {
        return $this->db->table('buku')
            ->select('buku.*, users.username')
            ->join('users', 'buku.id_user = users.id_user')
            ->where('buku.deleted_at', null)
            ->get()
            ->getResultArray();
    }
}
