<?php

namespace App\Models;

use CodeIgniter\Model;

class Coaach extends Model
{
    protected $table = 'coach'; // Define the table name
    protected $primaryKey = 'coach_id'; // Define the primary key (optional, but good practice)
    protected $allowedFields = [ // Define allowed fields for mass assignment (important!)
        'route_id', 'coach_type', 'seat_row', 'seat_column', 'vehicle_number',
        'supervisor_no', 'seat_layout', 'departure', 'arrival', 'main_boarding',
        'final_destination', 'total_fare'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect(); // Use CodeIgniter 4's database connection
    }

    public function get_info($id)
    {
        // Use CodeIgniter 4's query builder for better security and readability
        return $this->db->table($this->table)
            ->where($this->primaryKey, $id)
            ->get()
            ->getRowArray(); // Use getRowArray() for a single row as an array
    }

    public function delete_coach($id)
    {
        return $this->db->table($this->table)
            ->delete([$this->primaryKey => $id]); // Use query builder for delete
    }

    public function update_coach($data)
    {
        $oname = str_replace("'", "''", $data['main_boarding']); // Sanitize input
        $dname = str_replace("'", "''", $data['final_destination']); // Sanitize input
        $ts = $data['seat_layout_row'] * $data['seat_layout_column'];

        $dataToUpdate = [
            'route_id' => $data['cc_route_id'],
            'coach_type' => $data['coach_type'],
            'seat_row' => $data['seat_layout_row'],
            'seat_column' => $data['seat_layout_column'],
            'vehicle_number' => $data['vehicle_number'],
            'supervisor_no' => $data['supervisor_no'],
            'seat_layout' => $ts,
            'departure' => $data['departure'],
            'arrival' => $data['arrival'],
            'main_boarding' => $oname, // Use sanitized input
            'final_destination' => $dname, // Use sanitized input
            'total_fare' => $data['total_fare'],
        ];

        return $this->db->table($this->table)
            ->where($this->primaryKey, $data['coach_id'])
            ->update($dataToUpdate); // Use query builder for update
    }
}