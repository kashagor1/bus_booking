<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table            = 'tickets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function get_tickets($date)
    {
        // Use CodeIgniter's query builder to execute the custom SQL query
        $builder = $this->db->table('tickets');
        
        $builder->select('pnr, SUM(fare) as fare, GROUP_CONCAT(seat_no) AS seats, source, trip_id, destination')
                ->where('b_date', $date)
                ->groupBy('pnr'); // Group by 'pnr' to aggregate fare and seat numbers

        // Execute the query and return the results
        $tickets = $builder->get()->getResultArray();

        return $tickets;
    }

    public function count_tickets($date)
    {
        $tickets = $this->where('b_date', $date)->countAllResults();
        return $tickets;
    }

}
