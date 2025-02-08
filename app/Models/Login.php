<?php

namespace App\Models;

use CodeIgniter\Model;

class Login extends Model
{
    protected $table = 'nusers';  // Define the table name
    protected $primaryKey = 'id'; // Define the primary key (Good practice)
    protected $allowedFields = ['username', 'password', 'role_id']; // Allowed fields for mass assignment (CRUCIAL!)

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function checkUser($data)
    {
        $builder = $this->db->table($this->table); // Use query builder
        $builder->where('username', $data['user_name']);
        
        $user = $builder->get()->getRow();


        if ($user && password_verify($data['password'], $user->password)) { // Verify password hash
            return $user;
        } else {
            return null; // Or false, or throw an exception – handle as needed
        }
    }
    
    public function register_user($in)
    {
        $data = [
            'username' => $in['username'],
            'password' => password_hash($in['password'], PASSWORD_DEFAULT), // Hash the password
        ];

        return $this->db->table($this->table)->insert($data); // Use query builder and mass assignment
    }
}