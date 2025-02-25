<?php

namespace App\Models;

use CodeIgniter\Model;

class Person extends Model
{
    protected $table = 'nusers'; // Define the table name (good practice)
    protected $primaryKey = 'id'; // Define the primary key (good practice)
    protected $allowedFields = ['fullname', 'phone', 'email', 'password']; // Allowed fields for mass assignment (CRUCIAL!)

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function make_refund($pnr)
    {
        return $this->db->table('refundlist')
            ->where('pnr', $pnr)
            ->set('status', '1')
            ->update();
    }

    public function get_refundlist($user)
    {
        return $this->db->table('refundlist')
            ->where('username', $user)
            ->get()
            ->getResultArray();
    }

    public function get_all_refundlist()
    {
        return $this->db->table('refundlist')
            ->where('status', '0')
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function cancel_ticket($data)
    {
        $ticket = $this->db->table('tickets')
            ->where('pnr', $data['pnr'])
            ->where('username', $data['user'])
            ->get()
            ->getRow();

        if (!$ticket) {
            return false; // Ticket not found
        }

        $dDate = $this->db->table('tickets')
            ->select('departure_date')
            ->join('trips', 'tickets.trip_id = trips.trip_id')
            ->where('pnr', $data['pnr'])
            ->get()
            ->getRow()->departure_date; // Get departure date

        date_default_timezone_set('Asia/Dhaka');
        $currentDate = date('Y-m-d');
        $dateDiff = floor((strtotime($dDate) - strtotime($currentDate)) / (60 * 60 * 24));

        if ($dateDiff < 2) {
            return false; // Cancellation not allowed
        }

        $tickets = $this->db->table('tickets')
            ->where('pnr', $data['pnr'])
            ->where('username', $data['user'])
            ->get()
            ->getResultArray();

        if (empty($tickets)) {
            return false; // No tickets found
        }

        $trip_id = $tickets[0]['trip_id'];
        $fare = count($tickets) * $tickets[0]['fare'];
        $origin = $tickets[0]['source'];
        $destination = $tickets[0]['destination'];
        $b_date = $tickets[0]['b_date'];
        $seats = implode(',', array_column($tickets, 'seat_no')); // More efficient way to get seats

        $user = $this->db->table('nusers')
            ->where('username', $data['user'])
            ->get()
            ->getRow();

        $refundData = [
            'pnr' => $data['pnr'],
            'trip_id' => $trip_id,
            'username' => $data['user'],
            'seats' => $seats,
            'amount' => $fare,
            'origin' => $origin,
            'destination' => $destination,
            'j_date' => $b_date,
            'status' => '0',
            'bkash' => $user ? $user->phone : null, // Use null if user not found
        ];

        $this->db->transStart(); // Start transaction for atomicity

        $refundInsert = $this->db->table('refundlist')->insert($refundData);
        $ticketDelete = $this->db->table('tickets')
            ->where('pnr', $data['pnr'])
            ->delete();

        if ($refundInsert && $ticketDelete) {
            $this->db->transComplete();
            return true;
        } else {
            $this->db->transRollback();
            return false;
        }
    }


    public function get_tickets($user)
    {
        try {
            $pnrs = $this->db->table('tickets')
                ->select('pnr')
                ->where('username', $user)
                ->distinct()
                ->orderBy('b_date', 'DESC')
                ->get()
                ->getResultArray();

            $data = [];
            foreach ($pnrs as $pnr) {
                $tickets = $this->db->table('tickets')
                    ->join('trips', 'tickets.trip_id = trips.trip_id')
                    ->join('coach', 'trips.coach_id = coach.coach_id')
                    ->where('tickets.pnr', $pnr['pnr'])
                    ->get()
                    ->getResultArray();

                $seatInfo = $tickets[0];
                $nseat = [
                    'boarding' => $seatInfo['source'],
                    'destination' => $seatInfo['destination'],
                    'b_date' => $seatInfo['b_date'],
                    'j_date' => $seatInfo['departure_date'],
                    'fare' => $seatInfo['fare'],
                    'pnr' => $seatInfo['pnr'],
                    'seats' => implode(',', array_column($tickets, 'seat_no')), // Efficient way to get seats
                ];
                $data[] = $nseat;
            }
            return $data;
        } catch (\Exception $e) {
            $data = [];

            return $data; // Or handle the exception as needed
        }

    }

    public function print_info($pnr)
    {
        $query = $this->db->table('trips')
            ->join('coach', 'trips.coach_id = coach.coach_id')
            ->join('tickets', 'trips.trip_id = tickets.trip_id')
            ->where('pnr', $pnr)
            ->get()
            ->getResultArray();

        if (empty($query)) {
            return null; // Or handle the case where no ticket is found
        }

        $data = $query[0];
        $data['seats'] = implode(',', array_column($query, 'seat_no'));
        return $data;
    }

    public function get_uinfo($user)
    {
        return $this->db->table($this->table)
            ->where('username', $user)
            ->get()
            ->getRow();
    }

    public function update_uinfo($data)
    {
        $username = $data['email'];
        $updateData = [
            "fullname" => $data['fullname'], // No need for extra quotes
            "phone" => $data['phone'],       // No need for extra quotes
        ];

        if (!empty($data['password'])) { // Only update password if a new one is provided
            $updateData['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $this->db->table($this->table)
            ->where('username', $username)
            ->update($updateData);
    }
}