<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomModel extends Model
{
    protected $table = 'rooms'; // pastikan nama tabel sesuai dengan database Anda
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'room_number',
        'room_type',
        'status',
        'price',
        'description'
    ];
    protected $useTimestamps = true;
}