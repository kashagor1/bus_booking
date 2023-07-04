<?php


class Hom extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);

    }

    public function slogin($in)
    {
        $sq = "SELECT * FROM nusers WHERE username='$in[loginUsername]'";
        $res = $this->db->query($sq)->row();
        if (($res->password == $in['loginPassword'])) {
            return true;
        } else {
            return false;
        }

    }

    public function register_user($in)
    {
        $userName = $in['email'];
        $phone = $in['phone'];
        $password = md5($in['registerPassword']);
        $fullname = $in['fullName'];
        $role = 1;
        $status = 1;
        $qq = "INSERT INTO `nusers`( `username`, `password`, `fullname`,`phone`, `email`) VALUES ('$userName','$password','$fullname','$phone','$userName')";
        if ($this->db->query($qq)) {
            return true;
        } else {
            return false;
        }

    }
    public function get_routes($in)
    {

        $in_or = str_replace("'", "''", $in['origin']);
        $in_ds = str_replace("'", "''", $in['destination']);
        $qq = "SELECT DISTINCT route_id
        FROM coach
        WHERE route_id IN (
            SELECT route_id
            FROM routes
            WHERE route_name = '$in_or'
                AND route_id IN (
                    SELECT route_id
                    FROM routes
                    WHERE route_name = '$in_ds'
                        AND point_type IN (1, 3)
                )
                AND point_type IN (0, 2)
        )
        ORDER BY route_id ASC";
        $res = $this->db->query($qq)->result_array();

        return $res;


    }
    public function or_route($id)
    {
        $qq = "SELECT route_name FROM routes WHERE route_id=$id ORDER BY or_id ASC";
        $res = $this->db->query($qq)->result_array();
        return $res;
    }

    public function no_av_seats($id)
    {
        $qq = "SELECT * FROM tickets WHERE trip_id=$id";
      //  echo $qq;
        $res = $this->db->query($qq)->num_rows();

        return $res;

    }
    public function get_fare($data)
    {

        $qqqq = "SELECT * FROM routes WHERE  route_id='$data[rid]' AND point_type = 1 ";
        $dddd = $this->db->query($qqqq)->row();
        $final_price = $dddd->fare;
        //echo $dddd->route_name;
        $dname = str_replace("''", "'", $data['destination']);
        if ($dddd->route_name == $dname) {
            $qq = "SELECT * FROM routes WHERE route_name='$data[origin]' AND route_id='$data[rid]' AND point_type IN (0,2)";
            $dd = $this->db->query($qq)->row();
            $final_price -= $dd->fare;
            //echo $final_price;
        } else {
            $qq = "SELECT * FROM routes WHERE route_name='$data[origin]' AND route_id='$data[rid]' AND point_type IN (0,2)";
            $dd = $this->db->query($qq)->row();
            $op = $dd->fare;
            $qqq = "SELECT * FROM routes WHERE route_name='$data[destination]' AND route_id='$data[rid]' AND point_type IN (1,3)";
            $ddd = $this->db->query($qqq)->row();
            $dp = $ddd->fare;

            $final_price = $final_price - $op - $dp;
            //echo $data['destination']."-".$op."-".$dp;
        }
        return $final_price;
    }
    public function get_bus($in)
    {
        $routes = $this->get_routes($in);
        $dname = str_replace("'", "''", $in['destination']);
        $oname = str_replace("'", "''", $in['origin']);
        $result = array();
        if (count($routes) > 0) {
            foreach ($routes as $row) {
                $list = "SELECT * FROM routes, company, coach,trips
                WHERE coach.route_id = routes.route_id
                AND company.company_id = routes.company_id
                AND trips.coach_id = coach.coach_id
                AND routes.route_name='$dname' AND trips.departure_date='$in[date]' AND routes.route_id =$row[route_id]";
                //   echo $list;
                //   echo "<br>";
                $query = $this->db->query($list);
                //    echo $list.'<br>';
                $res = $query->result_array();
                foreach ($res as $rdata) {
                 //   var_dump($rdata);
                    // echo "<br>";
                    // die;
                    $cid = $rdata['trip_id'];

                    $price_check = array(
                        'origin' => $oname,
                        'destination' => $dname,
                        'rid' => $rdata['route_id']
                    );

                    $date = $in['date'];
                    date_default_timezone_set('Asia/Dhaka');

                    $current_date = date("Y-m-d");
                    $current_time = date("h:iA");
                    $departure_time = date("h:iA", strtotime($rdata['departure']));

                    if ($date === $current_date && strtotime($current_time) < strtotime($departure_time)) {
                        $rdata['final_fare'] = $this->get_fare($price_check);
                        $rdata['or_route'] = $this->or_route($rdata['route_id']);
                        $rdata['av_seats'] = $this->no_av_seats($cid, $date);
                       // echo $current_time." ".$departure_time;die;
                        $result[] = $rdata;
                    }else if ($date > $current_date) {
                        $rdata['final_fare'] = $this->get_fare($price_check);
                        $rdata['or_route'] = $this->or_route($rdata['route_id']);
                        $rdata['av_seats'] = $this->no_av_seats($cid);

                        $result[] = $rdata;
                    } else {

                    }


                }
            }
          //  die;
            // var_dump($result);
            return $result;
        } else {
            return 0;
        }

    }


    public function process_payment($post)
    {

        // var_dump($post);die;
        //$post = $this->session->userdata;
        $bookingData = $post['booking_data'];
        $username = $post['username'];
        $personalInfo = $post['personal_info'];

        // Parse the selected seats and corresponding personal information
        $selectedSeats = $personalInfo['seat'];
        $fare = $post['booking_data']['fare'];
        $passengerNames = $personalInfo['name'];
        //var_dump($post);die;
        date_default_timezone_set('Asia/Dhaka');

        $currentDate = date('Y-m-d');


        // Generate a unique PNR (assuming you have a function to generate it)
        $pnr = $this->generatePNR();

        // Generate tickets for each passenger
        $tickets = array();
        foreach ($selectedSeats as $index => $seat) {
            $passengerName = $passengerNames[$index];

            $ticket = array(
                'pnr' => $pnr,
                'name' => $passengerName,
                'trip_id' => $bookingData['trip_id'],
                'source' => str_replace("'", "''", $bookingData['origin']),
                'destination' => str_replace("'", "''", $bookingData['destination']),
                'seat_no' => $seat
            );

            $tickets[] = $ticket;

            // You can insert the ticket data into the database here
            // Assuming you have a function to insert data into the "tickets" table
            // insertTicket($ticket);
        }
        $ti = count($tickets);
        // foreach ($tickets as $ticket) {
        //     $qq = "SELECT status FROM seats WHERE seat_no='$ticket[seat_no]' AND coach=$bookingData[coach_id]";
        //     $res = $this->db->query($qq)->row();
        //     if ($res->status == 'open') {
        //         $ti++;
        //     }
        // }
        if ($ti == count($tickets)) {
            // Example of accessing the generated tickets
            foreach ($tickets as $ticket) {
                $qq = "INSERT INTO `tickets`(`pnr`, `name`, `trip_id`, `source`, `destination`, `phone_number`, `seat_no`, `username`, `b_date`,`fare`) VALUES 
    ('$ticket[pnr]','$ticket[name]','$ticket[trip_id]','$ticket[source]','$ticket[destination]','12345','$ticket[seat_no]','$username','$currentDate','$fare
    ')";
                //Wecho $qq;die;
                $this->db->query($qq);
                // $upseat = "UPDATE seats SET status='booked' WHERE seat_no='$ticket[seat_no]' AND coach=$bookingData[coach_id]";
                // $this->db->query($upseat);


            }
            $purchase_info = "INSERT INTO `purchase_info`( `username`, `pnr`, `booking_date`, `issuing_date`) VALUES 
            ('$username','$pnr','$bookingData[date]','$currentDate')";
            $this->db->query($purchase_info);
            return true;

        } else {
            return false;
        }

        // Function to generate a unique PNR




    }



    // Function to generate a unique 12-digit PNR
    public function generatePNR()
    {
        $pnr = '';

        // Generate a random 10-digit number
        for ($i = 0; $i < 10; $i++) {
            $pnr .= mt_rand(0, 9);
        }

        // Add a checksum digit to ensure a 12-digit PNR
        $pnr .= $this->calculateChecksum($pnr);

        return $pnr;
    }

    // Function to calculate the checksum digit for a given number
    public function calculateChecksum($number)
    {
        $sum = 0;
        $digits = str_split($number);

        // Multiply odd-positioned digits by 3 and sum all digits
        for ($i = 0; $i < count($digits); $i++) {
            $sum += ($i % 2 == 0) ? $digits[$i] * 3 : $digits[$i];
        }

        // Calculate the checksum digit
        $checksum = (10 - ($sum % 10)) % 10;

        return $checksum;
    }



}