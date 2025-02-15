<?php

namespace App\Models;

use CodeIgniter\Model;

class Route extends Model
{
    protected $table = 'routes'; // Define the table name
    protected $primaryKey = 'id'; // Define the primary key
    protected $allowedFields = ['route_id', 'company_id', 'or_id', 'route_name', 'fare', 'point_type']; // Allowed fields for mass assignment (CRUCIAL!)

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function get_route()
    {
        $res = $this->db->table($this->table)->selectMax('route_id', 'route_id')->get()->getRowArray();
        return $res['route_id'];
    }

    public function cr_route($data)
    {
        $rid = $data['route_id'];
        $cid = $data['company_id'];
        $rnames = $data['route_name'];
        $rfares = $data['fare'];
        $rtypes = $data['destination_type'];
        $or_ids = $data['or_id']; // Corrected variable name for consistency

        $routeData = []; // Array to hold the data for bulk insert

        for ($i = 0; $i < count($rnames); $i++) {
            $name = str_replace("'", "''", $rnames[$i]); // Sanitize input
            $routeData[] = [
                'route_id' => $rid,
                'company_id' => $cid,
                'or_id' => $or_ids[$i], // Use the correct variable name
                'route_name' => $name,
                'fare' => $rfares[$i],
                'point_type' => $rtypes[$i],
            ];
        }

        return $this->db->table($this->table)->insertBatch($routeData); // Use insertBatch for efficiency
    }

    public function list_routes()
    {
        $query = $this->db->table($this->table)->orderBy('route_id', 'DESC')->get();
        return $query->getResultArray(); // Return as array; let controller handle JSON encoding
    }

    public function get_r_info($id)
    {
        return $this->db->table($this->table)->where('id', $id)->get()->getResultArray();
    }

    public function up_r($data)
    {
        return $this->db->table($this->table)
            ->set($data['field'], $data['val']) // Use set() for updates
            ->where('id', $data['id'])
            ->update();
    }

    public function del_route($id)
    {
        return $this->db->table($this->table)->where('route_id', $id)->delete();
    }

    public function del_w_route($id)
    {
        return $this->db->table($this->table)->where('route_id', $id)->delete();
    }

    public function get_full_route($id)
    {
        return $this->db->table($this->table)->where('route_id', $id)->orderBy('or_id', 'ASC')->get()->getResultArray();
    }

    public function update_bulk_route($data)
    {
        $name = str_replace("'", "''", $data['route_name']); // Sanitize input

        return $this->db->table($this->table)
            ->set('route_name', $name)
            ->set('or_id', $data['or_id'])
            ->set('fare', $data['fare'])
            ->set('point_type', $data['point_type'])
            ->where('id', $data['id'])
            ->update();

        // The commented-out code for inserting a new row if no rows are updated
        // is not needed with the query builder's update() method.  It will
        // simply do nothing if no rows match the where clause.
    }

    public function update_coach($data)
    {
        $name = str_replace("'", "''", $data['route_name']); // Sanitize input

        $builder = $this->db->table('coach')->where('route_id', $data['route_id']);

        if ($data['point_type'] == 0) {
            $builder->set('main_boarding', $name);
        } else {
            $builder->set('final_destination', $name);
            $builder->set('total_fare', $data['fare']);
        }

        return $builder->update(); // Return the result of the update
    }

    public function list_routes2()
    {
        $routeIds = $this->db->table($this->table)
            ->select('route_id as id')
            ->distinct()
            ->orderBy('route_id', 'DESC')
            ->get()
            ->getResultArray();

        $routes = [];

        foreach ($routeIds as $row) {
            $id = $row['id'];

            $route = $this->db->table($this->table)
                ->select('route_name,company_id')
                ->where('route_id', $id)
                ->where('point_type', 0)
                ->get()
                ->getRow();
            $com_name =  $this->db->table('company')->select('company_name')->where('company_id', $route->company_id)->get()->getRow();
            $route2 = $this->db->table($this->table)
                ->select('route_name, fare')
                ->where('route_id', $id)
                ->where('point_type', 1)
                ->get()
                ->getRow();

             if ($route && $route2) { // Check if both queries returned results. Very important!
                $routes[] = [
                    'id' => $id,
                    'route_name' => $route->route_name,
                    'route_name2' => $route2->route_name,
                    'fare' => $route2->fare,
                    'company_name' => $com_name->company_name
                ];
            } // else {
                // Handle the case where one or both routes are not found.
                // You might want to log an error or skip this route.
            // }


        }

        return $routes;
    }
}