<?php

namespace App\Models;

use CodeIgniter\Model;

class Dashboards extends Model
{
    protected $table = 'company'; // Important: Define the table name
    protected $primaryKey = 'company_id'; // Define the primary key
    protected $allowedFields = [ // Define allowed fields for mass assignment (CRUCIAL!)
        'company_name',
        'company_phone',
        'company_address'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect(); // Use CodeIgniter 4's database connection

    }
    public function count_trips($date)
    {
        // Use CodeIgniter's Query Builder to count trips
        return $this->db->table('trips')
            ->where('trip_status', 1) // status should be 1 (active)
            ->where('departure_date', $date) // Check for the given date
            ->countAllResults(); // Count matching results
    }
    public function count_users()
    {
        return $this->db->table('nusers')->countAllResults();
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
    public function count_companies()
    {
        return $this->db->table('company')->countAllResults();
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


    public function create_company_user($data)
    {
        $insertData = [
            'company_id' => $data['company_id'],
            'user_id' => $data['user_id'],
            'role' => isset($data['role_type']) ? $data['role_type'] : 'default_role',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->transStart();

        $res = $this->db->table('company_users')->insert($insertData);

        if ($res) {
            $insertedID = $this->db->insertID();
            $this->db->transComplete();
            return $insertedID;
        } else {
            $this->db->transRollback();
            return false;
        }
    }

    public function get_cusers($id)
    {
        return $this->db->table('company_users')
            ->join('nusers', 'company_users.user_id = nusers.id') // Corrected join
            ->where('company_users.company_id', $id) // Fixed condition
            ->get()
            ->getResultArray(); // Fixed method name
    }
    public function get_cuser_info($id)
    {
        return $this->db->table('nusers')->where('id', $id)->get()->getRowArray();
    }
    function user_update_validation($a, $b)
    {
        return $a == $b;
    }
    public function update_user_role($id, $role)
    {
        return $this->db->table('company_users')
            ->where('user_id', $id)
            ->update(['role' => $role]);
    }


    public function update_c_user($id, $postData)
    {
        // Fetch current user info and convert to array
        $r = (array) $this->get_cuser_info($id);

        // Define the user data array
        $userData = [
            'username' => $postData['username'],
            'role_id' => $postData['role_type'],
            'fullname' => $postData['fullName'],
            'password' => $postData['registerPassword'],
            'phone' => $postData['phone'],
            'email' => $postData['email'],
        ];

        // Debugging


        // Array to store updated fields
        $data = [];

        foreach ($userData as $key => $value) {
            // Check if the key exists in fetched data
            if ($r[$key] != $value) {
                if ($key == 'password') {
                    $data['password'] = password_hash($value, PASSWORD_DEFAULT);
                } else {
                    $data[$key] = $value;
                }
                if ($key == 'role_id') {
                    $this->update_user_role($id, $value);
                }
            }
        }
        // Only update if there are changes
        if (!empty($data)) {
            return $this->db->table('nusers')->where('id', $id)->update($data);
        }
        return false;
    }

    public function get_com_id($id)
    {
        return $this->db->table('company_users')
            ->select('company_id') // Corrected the column name
            ->where('user_id', $id)
            ->get()
            ->getRow();
    }








}