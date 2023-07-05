<?php


class Person extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);

    }

    public function make_refund($pnr)
    {
        $qq = "UPDATE `refundlist` SET status='1' where pnr='$pnr'";
        $this->db->query($qq);
        return true;
    }

    public function get_refundlist($user)
    {
        $q = "SELECT * FROM `refundlist` WHERE username='$user'";
        $res = $this->db->query($q)->result_array();
        return $res;
    }
    public function get_all_refundlist()
    {
        $q = "SELECT * FROM `refundlist` where status='0' ORDER BY id DESC";
        $res = $this->db->query($q)->result_array();
        return $res;
    }
    public function cancel_ticket($data)
    {

        $qq = "SELECT * FROM tickets WHERE tickets.pnr='$data[pnr]' AND tickets.username='$data[user]'";
        $newq = "SELECT departure_date FROM tickets,trips WHERE pnr='$data[pnr]' and tickets.trip_id=trips.trip_id";
        $dDate = $this->db->query($newq)->row()->departure_date;
        date_default_timezone_set('Asia/Dhaka');

        $currentDate = date('Y-m-d');
        $dateDiff = floor((strtotime($dDate) - strtotime($currentDate)) / (60 * 60 * 24));
        if($dateDiff<2){
            return false;
        }


        $ata = $this->db->query($qq)->result_array();
        if (count($ata) == 0) {
            return false;
        }
        $tinfo = $ata[0];
        $trip_id = $tinfo['trip_id'];

        $fare = count($ata) * $tinfo['fare'];
        $origin = $tinfo['source'];
        $destination = $tinfo['destination'];
        $b_date = $tinfo['b_date'];
        $seats = "";
        foreach ($ata as $seat) {
            $seats .= $seat['seat_no'] . ",";
        }
        $seats = rtrim($seats, ',');


        $uq = "SELECT * FROM `nusers` where username='$data[user]'";
        $row = $this->db->query($uq)->row();

        $rfli = "INSERT INTO `refundlist`(`id`,`pnr`, `trip_id`, `username`,`seats`, `amount`, `origin`, `destination`, `j_date`, `status`, `bkash`) VALUES
         (NULL,'$data[pnr]','$trip_id','$data[user]','$seats','$fare','$origin','$destination','$b_date','0','$row->phone')";
        $delT = "DELETE FROM `tickets` WHERE `pnr`='$data[pnr]'";
        // echo $rfli;die;
        if ($this->db->query($rfli) && $this->db->query($delT)) {
            return true;
        } else {
            return false;
        }
    }
    public function get_tickets($user)
    {
        // echo $user;die;
        $qq = "SELECT distinct pnr FROM tickets WHERE username='$user' order by b_date desc, ticket_id desc";
        $res = $this->db->query($qq)->result_array();
        $data = array();
        foreach ($res as $row) {
            //   echo $row['pnr'];
            $qq = "SELECT * FROM tickets,trips,coach WHERE tickets.pnr='$row[pnr]' AND trips.coach_id=coach.coach_id AND tickets.trip_id=trips.trip_id";
            $ata = $this->db->query($qq)->result_array();
            $seatInfo = $ata[0];
            //  var_dump($seatInfo);
            $boarding = $seatInfo['source'];
            $destination = $seatInfo['destination'];
            $b_date = $seatInfo['b_date'];
            $date = $seatInfo['departure_date'];
            $fare = $seatInfo['fare'];
            $pnr = $seatInfo['pnr'];

            $nseat = array(
                'boarding' => $boarding,
                'destination' => $destination,
                'b_date' => $b_date,
                'j_date' => $date,
                'fare' => $fare,
                'pnr' => $pnr,
                'seats' => ''
            );
            foreach ($ata as $seat) {
                $nseat['seats'] .= $seat['seat_no'] . ",";
            }


            $data[] = $nseat;
        }
        return $data;

    }

    public function print_info($pnr)
    {
        $q = "SELECT * FROM trips,coach,tickets WHERE pnr='$pnr' AND trips.trip_id=tickets.trip_id AND trips.coach_id=coach.coach_id";
        $query = $this->db->query($q)->result_array();
        $data = $query[0];
        $seats = "";
        foreach ($query as $que) {
            $seats .= $que['seat_no'] . ',';
        }
        $seats = rtrim($seats, ',');
        $data['seats'] = $seats;
        return $data;
        //  var_dump($data);die;
    }
    public function get_uinfo($user)
    {
        $q = "SELECT * FROM nusers where username='$user'";
        $res = $this->db->query($q)->row();
        return $res;
    }
    public function update_uinfo($data)
    {
        $username = $data['email'];
        $data = [
            "fullname" => "$data[fullname]",
            "password" => md5($data['password']),
            "phone" => "$data[phone]"
        ];

        $this->db->where('username', $username);
        $this->db->update('nusers', $data);

    }
}