<?php

namespace App\Models;

use CodeIgniter\Model;

class Dashboards extends Model
{
    protected $table = 'company'; // Important: Define the table name
    protected $primaryKey = 'company_id'; // Define the primary key
    protected $allowedFields = [ // Define allowed fields for mass assignment (CRUCIAL!)
        'company_name', 'company_phone', 'company_address'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect(); // Use CodeIgniter 4's database connection
    }

    public function create_company($data)
    {
        // Use query builder for security and readability
        return $this->db->table($this->table)->insert($data);  // Insert directly using the $data array.
    }

    public function list_company()
    {
        // Use query builder
        $query = $this->db->table($this->table)->get();
        return $query->getResultArray(); // Return result as array.  No need to json_encode here; let the controller handle it.
    }

    public function get_c_info($id)
    {
        $data = $this->db->table($this->table)
            ->where($this->primaryKey, $id)
            ->get()
            ->getRowArray();
        if ($data != null) {
            return $data; 
        } else {
            $data['company_name'] = 'No data found';
            return $data; 
        }
    }

    public function update_c_info($id, $data)
    {
        return $this->db->table($this->table)
            ->where($this->primaryKey, $id)
            ->update($data);
    }

    public function delete_company($id)
    {
        return $this->db->table($this->table)
            ->where($this->primaryKey, $id)
            ->delete();
    }

    public function coachlist()
    {
        return $this->db->table('coach')->get()->getResultArray();
    }

    public function create_coach($data)
    {
        $oname = str_replace("'", "''", $data['main_boarding']); // Sanitize input
        $dname = str_replace("'", "''", $data['final_destination']); // Sanitize input
        $tseats = $data['seat_layout_row'] * $data['seat_layout_column'];

        $coachData = [ // Use an array for insert data
            'company_id' => $data['company_id'],
            'route_id' => $data['cc_route_id'],
            'coach_type' => $data['coach_type'],
            'vehicle_number' => $data['vehicle_number'],
            'supervisor_no' => $data['supervisor_no'],
            'seat_layout' => $tseats,
            'seat_row' => $data['seat_layout_row'],
            'seat_column' => $data['seat_layout_column'],
            'departure' => $data['departure'],
            'arrival' => $data['arrival'],
            'main_boarding' => $oname,
            'final_destination' => $dname,
            'total_fare' => $data['total_fare'],
        ];

        return $this->db->table('coach')->insert($coachData); // Insert using the array
    }
}