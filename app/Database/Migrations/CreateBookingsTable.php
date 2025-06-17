<?php
// filepath: d:\laragon\www\Hotel\app\Database\Migrations\2024-01-01-000003_create_bookings_table.php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'booking_code' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'unique' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'room_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'guest_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'guest_email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'guest_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'check_in' => [
                'type' => 'DATE',
            ],
            'check_out' => [
                'type' => 'DATE',
            ],
            'nights' => [
                'type' => 'INT',
                'constraint' => 3,
            ],
            'guests' => [
                'type' => 'INT',
                'constraint' => 2,
            ],
            'room_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'total_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'special_requests' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'payment_method' => [
                'type' => 'ENUM',
                'constraint' => ['qris', 'bank_va', 'cod'],
            ],
            'bank_code' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'virtual_account' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'qr_code_url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'payment_proof' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'booking_status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'confirmed', 'cancelled', 'completed'],
                'default' => 'pending',
            ],
            'payment_status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'paid', 'failed', 'expired'],
                'default' => 'pending',
            ],
            'paid_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'expired_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('room_id', 'rooms', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('bookings');
    }

    public function down()
    {
        $this->forge->dropTable('bookings');
    }
}