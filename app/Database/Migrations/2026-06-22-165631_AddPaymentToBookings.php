<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaymentToBookings extends Migration
{
    public function up()
    {
        $fields = [
            'snap_token'     => [
                'type'       => 'VARCHAR', 
                'constraint' => 255, 
                'null'       => true
            ],
            'payment_status' => [
                'type'       => 'ENUM', 
                'constraint' => ['pending', 'success', 'expired', 'failed'], 
                'default'    => 'pending'
            ],
            'payment_type'   => [
                'type'       => 'VARCHAR', 
                'constraint' => 50, 
                'null'       => true
            ],
        ];
        
        $this->forge->addColumn('bookings', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('bookings', ['snap_token', 'payment_status', 'payment_type']);
    }
}