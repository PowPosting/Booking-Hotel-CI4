<?php
namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'room_type', 'check_in', 'check_out', 'total_price', 'status'];
}