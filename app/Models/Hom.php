<?php

namespace App\Models;

use CodeIgniter\Model;


class Hom extends Model
{
    protected $table = 'nusers'; // Good practice to define the table
    protected $primaryKey = 'id'; // Good practice to define the primary key
    protected $allowedFields = ['username', 'password', 'fullname','role_id', 'phone', 'email']; // Allowed fields for mass assignment (CRUCIAL!)


    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        $this->ticketModel = new TicketModel(); 
        $this->purchaseInfoModel = new PurchaseInfoModel(); 
    }

    public function slogin($in)
    {
        $builder = $this->db->table($this->table); // Use query builder
        $builder->where('username', $in['loginUsername']);
        $res = $builder->get()->getRow();

        if ($res && password_verify($in['loginPassword'], $res->password)) { // Verify password hash
            return $res;
        } else {
            return false;
        }
    }

    public function register_user($in)
    {
        $data = [
            'username' => $in['username'],
            'phone' => $in['phone'],
            'password' => password_hash($in['registerPassword'], PASSWORD_DEFAULT), // Hash the password
            'fullname' => $in['fullName'],
            'email' => $in['email'], // Added email field
        ];
        if(isset($in['role_type'])){
            $data['role_id'] = $in['role_type'];
        }
        $this->db->transStart();

        $res = $this->db->table($this->table)->insert($data); // Use query builder and mass assignment
        if ($res) {
            $insertedID = $this->db->insertID(); // Get the last inserted ID

            $this->db->transComplete();
            return $insertedID;
        } else {
            $this->db->transRollback();
            return false;
        }
    }

    public function get_routes($in)
    {
        $in_or = str_replace("'", "''", $in['origin']); // Sanitize input
        $in_ds = str_replace("'", "''", $in['destination']); // Sanitize input

        $qq = "SELECT DISTINCT route_id
        FROM coach
        WHERE route_id IN (
            SELECT route_id
            FROM routes
            WHERE route_name = ?
                AND route_id IN (
                    SELECT route_id
                    FROM routes
                    WHERE route_name = ?
                        AND point_type IN (1, 3)
                )
                AND point_type IN (0, 2)
        )
        ORDER BY route_id ASC";

        $res = $this->db->query($qq, [$in_or, $in_ds])->getResultArray(); // Parameterized query

        return $res;
    }

    public function or_route($id)
    {
        $qq = "SELECT route_name FROM routes WHERE route_id=? ORDER BY or_id ASC"; // Parameterized query
        $res = $this->db->query($qq, [$id])->getResultArray();
        return $res;
    }

    public function no_av_seats($id)
    {
        $qq = "SELECT * FROM tickets WHERE trip_id=?"; // Parameterized query
        $res = $this->db->query($qq, [$id])->getNumRows(); // Use getNumRows()

        return $res;
    }

    public function get_fare($data)
    {
        $qqqq = "SELECT * FROM routes WHERE  route_id=? AND point_type = 1"; // Parameterized query
        $dddd = $this->db->query($qqqq, [$data['rid']])->getRow();

        if (!$dddd) { // Handle the case where no route is found
          return 0; // Or throw an exception, or return an error value
        }

        $final_price = $dddd->fare;
        $dname = str_replace("''", "'", $data['destination']); // Sanitize input

        if ($dddd->route_name == $dname) {
            $qq = "SELECT * FROM routes WHERE route_name=? AND route_id=? AND point_type IN (0,2)"; // Parameterized query
            $dd = $this->db->query($qq, [$data['origin'], $data['rid']])->getRow();
            if ($dd) {
              $final_price -= $dd->fare;
            }
        } else {
            $qq = "SELECT * FROM routes WHERE route_name=? AND route_id=? AND point_type IN (0,2)"; // Parameterized query
            $dd = $this->db->query($qq, [$data['origin'], $data['rid']])->getRow();
            $op = $dd ? $dd->fare : 0; // Use 0 if $dd is null

            $qqq = "SELECT * FROM routes WHERE route_name=? AND route_id=? AND point_type IN (1,3)"; // Parameterized query
            $ddd = $this->db->query($qqq, [$data['destination'], $data['rid']])->getRow();
            $dp = $ddd ? $ddd->fare : 0; // Use 0 if $ddd is null

            $final_price = $final_price - $op - $dp;
        }
        return $final_price;
    }
    // ... (rest of the model code)
    public function get_bus($in)
    {
        $routes = $this->get_routes($in);
        $dname = str_replace("'", "''", $in['destination']); // Sanitize input
        $oname = str_replace("'", "''", $in['origin']); // Sanitize input
        $result = [];

        if (count($routes) > 0) {
            foreach ($routes as $row) {
                $list = "SELECT * FROM routes, company, coach, trips
                WHERE coach.route_id = routes.route_id
                AND company.company_id = routes.company_id
                AND trips.coach_id = coach.coach_id
                AND routes.route_name=? AND trips.departure_date=? AND routes.route_id =?"; // Parameterized query

                $query = $this->db->query($list, [$dname, $in['date'], $row['route_id']]);
                $res = $query->getResultArray();
                // var_dump($res);die;

                foreach ($res as $rdata) {
                    $cid = $rdata['trip_id'];

                    $price_check = [
                        'origin' => $oname,
                        'destination' => $dname,
                        'rid' => $rdata['route_id'],
                    ];

                    $date = $in['date'];
                    date_default_timezone_set('Asia/Dhaka');

                    $current_date = date("Y-m-d");
                    $current_time = date("h:iA");
                    $departure_time = date("h:iA", strtotime($rdata['departure']));

                    if ($date === $current_date && strtotime($current_time) < strtotime($departure_time)) {
                        $rdata['final_fare'] = $this->get_fare($price_check);
                        $rdata['or_route'] = $this->or_route($rdata['route_id']);
                        $rdata['av_seats'] = $this->no_av_seats($cid); // Removed extra $date argument
                        $result[] = $rdata;
                    } else if ($date > $current_date) {
                        $rdata['final_fare'] = $this->get_fare($price_check);
                        $rdata['or_route'] = $this->or_route($rdata['route_id']);
                        $rdata['av_seats'] = $this->no_av_seats($cid); // Removed extra $date argument
                        $result[] = $rdata;
                    }
                }
            }
            return $result;
        } else {
            return []; // Return an empty array instead of 0 for consistency
        }
    }


    // public function process_payment($post)
    // {
    //     $bookingData = $post['booking_data'];
    //     $username = $post['username'];
    //     $personalInfo = $post['personal_info'];

    //     $selectedSeats = $personalInfo['seat'];
    //     $fare = $post['booking_data']['fare'];
    //     $passengerNames = $personalInfo['name'];

    //     date_default_timezone_set('Asia/Dhaka');
    //     $currentDate = date('Y-m-d');

    //     $pnr = $this->generatePNR();

    //     $tickets = [];
    //     foreach ($selectedSeats as $index => $seat) {
    //         $passengerName = $passengerNames[$index];

    //         $ticket = [
    //             'pnr' => $pnr,
    //             'name' => $passengerName,
    //             'trip_id' => $bookingData['trip_id'],
    //             'source' => str_replace("'", "''", $bookingData['origin']), // Sanitize input
    //             'destination' => str_replace("'", "''", $bookingData['destination']), // Sanitize input
    //             'seat_no' => $seat,
    //         ];

    //         $tickets[] = $ticket;
    //     }

    //     if (count($tickets) == count($selectedSeats)) { // Corrected comparison
    //         foreach ($tickets as $ticket) {
    //             $ticketData = [  // Use an array for insert
    //                 'pnr' => $ticket['pnr'],
    //                 'name' => $ticket['name'],
    //                 'trip_id' => $ticket['trip_id'],
    //                 'source' => $ticket['source'],
    //                 'destination' => $ticket['destination'],
    //                 'phone_number' => '12345', // Replace with actual phone number handling
    //                 'seat_no' => $ticket['seat_no'],
    //                 'username' => $username,
    //                 'b_date' => $currentDate,
    //                 'fare' => $fare,
    //             ];
    //             $this->db->table('tickets')->insert($ticketData); // Use query builder and mass assignment
    //         }

    //         $purchase_info = [ // Use an array for insert
    //             'username' => $username,
    //             'pnr' => $pnr,
    //             'booking_date' => $bookingData['date'],
    //             'issuing_date' => $currentDate,
    //         ];
    //         $this->db->table('purchase_info')->insert($purchase_info); // Use query builder and mass assignment

    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
    public function process_payment($post)
    {
        $username = $post['username'];


        $bookingData = $post['booking_data'];
        $personalInfo = $post['personal_info'];
        
        $result = $this->confirm_tickets($username, $bookingData, $personalInfo); // Store the result
        if(isset($post['return_booking_data'])){

            $rbookingData  = $post['return_booking_data'];
            $rips = $post['personal_info'];
            $returnpersonalInfo['seat']  =  $rips['rseat'];
            $returnpersonalInfo['name']  = $rips['rname'];
            $returnResult = $this->confirm_tickets($username, $rbookingData, $returnpersonalInfo);
            return $returnResult && $result; // Return true only if BOTH are successful.
        }
        return $result;
    }

    private function confirm_tickets($username,$bookingData,$personalInfo){
        $fare =  $bookingData['fare'];
        $selectedSeats = $personalInfo['seat'];
        $passengerNames = $personalInfo['name'];
        $currentDate = date('Y-m-d'); 

        $pnr = $this->generatePNR();
        // Use a single transaction for atomicity (all operations succeed or none)
        $this->db->transBegin();

        try {
            foreach ($selectedSeats as $index => $seat) {
                $ticketData = [
                    'pnr' => $pnr,
                    'name' => $passengerNames[$index],
                    'trip_id' => $bookingData['trip_id'],
                    'source' => $bookingData['origin'], // No need for str_replace if using parameterized queries (see below)
                    'destination' => $bookingData['destination'], // No need for str_replace if using parameterized queries (see below)
                    'seat_no' => $seat,
                    'username' => $username,
                    'b_date' => $currentDate,
                    'fare' => $fare,
                    'phone_number' => '12345', //  Get the phone number! $personalInfo['phone'] ??  Handle missing phone numbers.
                ];

                $this->ticketModel->insert($ticketData); // Use the TicketModel
                
            }

            $purchase_info = [
                'username' => $username,
                'pnr' => $pnr,
                'booking_date' => $bookingData['date'],
                'issuing_date' => $currentDate,
            ];
            $this->purchaseInfoModel->insert($purchase_info); // Use the PurchaseInfoModel

            $this->db->transCommit();
            return true;

        } catch (\Exception $e) {
            $this->db->transRollback();
            // Log the error for debugging.  Important!
            log_message('error', $e->getMessage()); 
            return false; // Or return an error message for the user.
        }
    }



    public function generatePNR()
    {
        $pnr = '';
        for ($i = 0; $i < 10; $i++) {
            $pnr .= mt_rand(0, 9);
        }
        $pnr .= $this->calculateChecksum($pnr);
        return $pnr;
    }

    public function calculateChecksum($number)
    {
        $sum = 0;
        $digits = str_split($number);

        for ($i = 0; $i < count($digits); $i++) {
            $sum += ($i % 2 == 0) ? $digits[$i] * 3 : $digits[$i];
        }

        $checksum = (10 - ($sum % 10)) % 10;
        return $checksum;
    }
}

