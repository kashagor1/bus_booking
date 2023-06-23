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
        $this->db->where('coach.coach_id', 6);
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
        $qq = "SELECT * FROM seats WHERE coach=$data[cid] ORDER BY seat_id ASC";

        $results = $this->db->query($qq);
        $seats = array();
        foreach ($results->result() as $row) {

            $st = $row->status;
            $stn = $row->seat_no;
            $seat = array(
                'seat_no' => $stn
            );
            if ($st == "booked") {
                $qqr = "SELECT * FROM tickets WHERE seat_no='$stn' AND trip_id=$data[id]";
                $seat_rs = $this->db->query($qqr)->row();
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

        return $seats;
    }
    public function get_trip_list()
    {

        $qq = "SELECT * FROM trips";
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