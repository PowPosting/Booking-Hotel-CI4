<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users'; // nama tabel di database
    protected $primaryKey = 'id';

    protected $allowedFields = ['fullname', 'username', 'email', 'password', 'role'];
    protected $useTimestamps = true;
}