<?php


class Trips extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);


    }

    public function get_trip_number()
    {
        $data = $this->db->query("SELECT max(trip_id) as trip_id FROM trips")->result_array();
        // var_dump($data);die;
        //     echo ;die;
        if ($data[0]['trip_id'] == NULL) {
            return 1;
        }
        return $data[0]['trip_id'] + 1;
    }
    public function create_trip($data)
    {
        $qq = "INSERT INTO trips(`trip_id`, `coach_id`, `departure_date`) VALUES (NULL,'$data[cc_route_id]','$data[trip_date]')";

        if ($this->db->query($qq)) {
            return true;
        }
        return false;
    }
    public function get_trip_info($cid)
    {
        $this->db->select('*');
        $this->db->from('coach');
        $this->db->join('company', 'coach.company_id = company.company_id');
        $this->db->where('coach.coach_id', $cid);
        $query = $this->db->get();
        $data = array();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                
                $data['bus_no'] = $row->vehicle_number;
                $data['company_name'] = $row->company_name;
                $data['supervisor'] = $row->supervisor_no;
                $data['main_boarding'] = $row->main_boarding;
                $data['final_destination'] = $row->final_destination;
                $data['departure'] = $row->departure;
                $data['arrival'] = $row->arrival;
            }
            return $data;
        } else {
            return $data;
        }


    }
    public function get_seats_info($data)
    {
        $qq = "SELECT * FROM coach WHERE coach_id=$data[cid] "; 

        $results = $this->db->query($qq)->row();
        $seats = array();
        $rr = $results->seat_row;
        $col = $results->seat_column;
        for ($i=1; $i <= $rr ; $i++) { 
            
            for ($j=1; $j <= $col ; $j++) { 
               $stn = chr(64+$i).$j;
                
               //echo $stn;
                
          //  $st = $row->status;
            // $stn = $row->seat_no;
            $seat = array(
                'seat_no' => $stn
            );
            $qqr = "SELECT * FROM tickets WHERE seat_no='$stn' AND trip_id=$data[id]";
            $seat_rs = $this->db->query($qqr)->row();

            // echo $qqr."<br>";
            // var_dump($seat_rs); 
            // echo "<br>";
            if ($seat_rs != NULL) {
            
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
            $seats[]=$seat;

        }
        }

        return $seats;
    }


    public function cancel_trip($id){
        $qq = "SELECT * FROM tickets where trip_id='$id'";
        $rows = $this->db->query($qq)->result_array();
        foreach($rows as $row){
            $this->cancel_ticket($row['pnr']);
        }
        $qq = "UPDATE trips SET trip_status='0' WHERE trip_id='$id'";
        $this->db->query($qq);
    }

    public function cancel_ticket($pnr){

        $qq = "SELECT * FROM tickets WHERE tickets.pnr='$pnr'";
        $ata = $this->db->query($qq)->result_array();
        if( count($ata)==0){
            return false;
        }
        $tinfo = $ata[0];
        $trip_id = $tinfo['trip_id'];
        
        $fare = count($ata)*$tinfo['fare'];
        $origin = $tinfo['source'];
        $destination = $tinfo['destination'];
        $b_date = $tinfo['b_date'];
        $seats = "";
        $username = $tinfo['username'];
        foreach ($ata as $seat) {
            $seats .=$seat['seat_no'].",";
        }
        $seats = rtrim($seats, ',');


        $uq = "SELECT * FROM `nusers` where username='$username'";
        $row = $this->db->query($uq)->row();

        $rfli = "INSERT INTO `refundlist`(`id`,`pnr`, `trip_id`, `username`,`seats`, `amount`, `origin`, `destination`, `j_date`, `status`, `bkash`) VALUES
         (NULL,'$pnr','$trip_id','$username','$seats','$fare','$origin','$destination','$b_date','0','$row->phone')";
        $delT=  "DELETE FROM `tickets` WHERE `pnr`='$pnr'";
       // echo $rfli;die;
        if($this->db->query($rfli) && $this->db->query($delT)){
            return true;
        }else{
            return false;
        }
    }

   
    public function get_trip_list($st)
    {

        $qq = "SELECT * FROM trips where trip_status='$st' order by trip_id DESC";
        $res = $this->db->query($qq);
        if ($res->num_rows() > 0) {
            $trips = array();

            foreach ($res->result() as $row) {
                $tid = $row->trip_id;
                $cid = $row->coach_id;
                $dep_time = $row->departure_date;

                $nqq = "SELECT * FROM coach WHERE coach_id=$cid";
                $ress = $this->db->query($nqq)->row();
                $bus_no = $ress->vehicle_number;
                $origin = $ress->main_boarding;
                $destination = $ress->final_destination;
                $arrival = $ress->arrival;
                $departure = $ress->departure;
                $tripInfo = array(
                    'id' => $tid,
                    'cid' => $cid,
                    'bus_no' => $bus_no,
                    'origin' => $origin,
                    'date' => $dep_time,
                    'destination' => $destination,
                    'arrival' => $arrival,
                    'departure' => $departure
                );

                $trips[] = $tripInfo;

            }
            return $trips;
        }
    }

}