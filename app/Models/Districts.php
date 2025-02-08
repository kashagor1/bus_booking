<?php

namespace App\Models;

use CodeIgniter\Model;

class Districts extends Model
{
    protected $table = 'district'; // Define the table name (good practice)
    protected $primaryKey = 'district_id'; // Define the primary key (if applicable)
    protected $allowedFields = ['district_name']; // Allowed fields for mass assignment (important!)


    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect(); // Use CodeIgniter 4's database connection
    }

    public function getList() {
        $builder = $this->db->table('district'); // Use the table builder
        $query = $builder->select('district_name')->get(); // Select and get the results
    
        $resultArray = $query->getResultArray(); // Get the results as an array
    
        return $resultArray;
    }

    public function get_all_roi($id)
    {
        $data = [];

        $q = "SELECT route_name FROM routes WHERE route_id=? AND point_type=0"; // Use parameterized query
        $qq = "SELECT route_name, fare, company_id FROM routes WHERE route_id=? AND point_type=1"; // Use parameterized query

        $query = $this->db->query($q, [$id]); // Pass the $id as a parameter
        $resultA = $query->getResultArray();

        if (!empty($resultA)) { // Check if the result is not empty
            $data['main_boarding'] = $resultA[0]['route_name'];
        } else {
            $data['main_boarding'] = null; // Or handle the case where no route is found
        }



        $query = $this->db->query($qq, [$id]); // Pass the $id as a parameter
        $rss = $query->getResultArray();

        if (!empty($rss)) { // Check if the result is not empty
            $data['final_destination'] = $rss[0]['route_name'];
            $data['total_fare'] = $rss[0]['fare'];
            $data['company_id'] = $rss[0]['company_id'];
        } else {
            $data['final_destination'] = null; // Or handle the case where no route is found
            $data['total_fare'] = null;
            $data['company_id'] = null;
        }


        echo json_encode($data,true); // Return the array; let the controller handle JSON encoding
    }
}