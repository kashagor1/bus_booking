<?php

namespace App\Models;

use CodeIgniter\Model;

class Seats extends Model
{
    protected $table = 'seats'; // Define the table name
    protected $primaryKey = 'seat_id'; // Define the primary key
    protected $allowedFields = ['coach', 'seat_no', 'status']; // Allowed fields for mass assignment (CRUCIAL!)

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function all_seats($cid)
    {
        return $this->db->table($this->table)
            ->where('coach', $cid)
            ->orderBy('seat_id')
            ->get()
            ->getResultArray();
    }

    public function booked_seats($tid)
    {
        $query = $this->db->table('tickets')
            ->select('seat_no')
            ->distinct()
            ->where('trip_id', $tid)
            ->get()
            ->getResultArray();

        return $query; // No need to check for NULL; an empty array is fine
    }

    public function get_all_info($id)
    {
        return $this->db->table('coach')
            ->join('company', 'coach.company_id = company.company_id')
            ->where('coach.coach_id', $id)
            ->get()
            ->getResultArray();
    }
}