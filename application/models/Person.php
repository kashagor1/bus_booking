<?php


class Person extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);

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
                'seats'=> ''
             );
            foreach ($ata as $seat) {
                $nseat['seats'] .=$seat['seat_no'].",";
            }
            

            $data[] = $nseat;
        }
        return $data;
      
    }

    public function print_info($pnr){
        $q = "SELECT * FROM trips,coach,tickets WHERE pnr='$pnr' AND trips.trip_id=tickets.trip_id AND trips.coach_id=coach.coach_id";
        $query = $this->db->query($q)->result_array();
        $data  = $query[0];
        $seats = "";
        foreach($query as $que){
            $seats .=$que['seat_no'].',';
        }
        $seats = rtrim($seats, ',');
        $data['seats']=$seats;
        return $data;
      //  var_dump($data);die;
    }
    public function get_uinfo($user){
        $q = "SELECT * FROM nusers where username='$user'";
        $res = $this->db->query($q)->row();
        return $res;
    }
    public function update_uinfo($data){
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