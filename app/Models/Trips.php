<?php

namespace App\Models;

use CodeIgniter\Model;

class Trips extends Model
{
    protected $table = 'trips'; // Define the table name
    protected $primaryKey = 'trip_id'; // Define the primary key
    protected $allowedFields = ['coach_id', 'departure_date', 'trip_status']; // Allowed fields for mass assignment (CRUCIAL!)

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function get_trip_number()
    {
        $data = $this->db->table($this->table)->selectMax('trip_id', 'trip_id')->get()->getRowArray();
        return $data['trip_id'] === null ? 1 : $data['trip_id'] + 1;
    }

    public function create_trip($data)
    {
        $qq = "INSERT INTO trips(`trip_id`, `coach_id`, `departure_date`,`trip_status`) VALUES (NULL,'$data[cc_route_id]','$data[trip_date]',1)";

        if ($this->db->query($qq)) {
            return true;
        }
        return false;
    }

    public function get_trip_info($cid)
    {
        return $this->db->table('coach')
            ->join('company', 'coach.company_id = company.company_id')
            ->where('coach.coach_id', $cid)
            ->get()
            ->getRowArray(); // Use getRowArray() for single row result
    }

    public function get_seats_info($data)
    {
        $coach = $this->db->table('coach')->where('coach_id', $data['cid'])->get()->getRow();

        if (!$coach) {
          return []; // Return an empty array if coach not found
        }

        $seats = [];
        $rr = $coach->seat_row;
        $col = $coach->seat_column;

        for ($i = 1; $i <= $rr; $i++) {
            for ($j = 1; $j <= $col; $j++) {
                $stn = chr(64 + $i) . $j;

                $seat = ['seat_no' => $stn];

                $seat_rs = $this->db->table('tickets')
                    ->where('seat_no', $stn)
                    ->where('trip_id', $data['id'])
                    ->get()
                    ->getRow();

                if ($seat_rs) {
                    $seat['pnr'] = $seat_rs->pnr;
                    $seat['source'] = $seat_rs->source;
                    $seat['destination'] = $seat_rs->destination;
                    $seat['passenger_name'] = $seat_rs->name;
                    $seat['phone_number'] = $seat_rs->phone_number;
                } else {
                    $seat['pnr'] = "";
                    $seat['source'] = "";
                    $seat['destination'] = "";
                    $seat['passenger_name'] = "";
                    $seat['phone_number'] = "";
                }
                $seats[] = $seat;
            }
        }
        return $seats;
    }

    public function cancel_trip($id)
    {
        $tickets = $this->db->table('tickets')->where('trip_id', $id)->get()->getResultArray();

        foreach ($tickets as $ticket) {
            $this->cancel_ticket($ticket['pnr']);
        }

        return $this->db->table($this->table)
            ->where('trip_id', $id)
            ->set('trip_status', '0')
            ->update();
    }

    public function cancel_ticket($pnr)
    {
        $tickets = $this->db->table('tickets')->where('pnr', $pnr)->get()->getResultArray();

        if (empty($tickets)) {
            return false;
        }

        $tinfo = $tickets[0];
        $trip_id = $tinfo['trip_id'];
        $fare = count($tickets) * $tinfo['fare'];
        $origin = $tinfo['source'];
        $destination = $tinfo['destination'];
        $b_date = $tinfo['b_date'];
        $seats = implode(',', array_column($tickets, 'seat_no')); // More efficient way to get seats
        $username = $tinfo['username'];

        $user = $this->db->table('nusers')->where('username', $username)->get()->getRow();

        $refundData = [
            'pnr' => $pnr,
            'trip_id' => $trip_id,
            'username' => $username,
            'seats' => $seats,
            'amount' => $fare,
            'origin' => $origin,
            'destination' => $destination,
            'j_date' => $b_date,
            'status' => '0',
            'bkash' => $user ? $user->phone : null,
        ];

        $this->db->transStart();

        $refundInsert = $this->db->table('refundlist')->insert($refundData);
        $ticketDelete = $this->db->table('tickets')->where('pnr', $pnr)->delete();

        if ($refundInsert && $ticketDelete) {
            $this->db->transComplete();
            return true;
        } else {
            $this->db->transRollback();
            return false;
        }
    }

    public function get_trip_list($st)
    {
        $trips = $this->db->table($this->table)
            ->where('trip_status', $st)
            ->orderBy('trip_id', 'DESC')
            ->get()
            ->getResultArray();

        $result = [];
        foreach ($trips as $row) {
            $coach = $this->db->table('coach')->where('coach_id', $row['coach_id'])->get()->getRow();
            if ($coach) { // Check if coach exists. Very important!
                $result[] = [
                    'id' => $row['trip_id'],
                    'cid' => $row['coach_id'],
                    'bus_no' => $coach->vehicle_number,
                    'origin' => $coach->main_boarding,
                    'date' => $row['departure_date'],
                    'destination' => $coach->final_destination,
                    'arrival' => $coach->arrival,
                    'departure' => $coach->departure,
                ];
            } // else {
                // Handle the case where the coach is not found.
                // You might want to log an error or skip this trip.
            // }
        }
        return $result;
    }
}