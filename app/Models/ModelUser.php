<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUser extends Model
{
    protected $table = "users";
    protected $primaryKey = "id_user";
    protected $useTimestamps = true;
    protected $allowedFields = ['email', 'username', 'password', 'role'];
}
