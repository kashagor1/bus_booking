<?php


class Seats extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);

    }

    public function all_seats($cid){
       $res =  $this->db->query("SELECT * FROM seats WHERE coach=$cid ORDER BY seat_id")->result_array();
       return $res;
    }
    public function booked_seats($tid){
        $res = "SELECT DISTINCT seat_no FROM tickets WHERE trip_id=$tid";
        $query= $this->db->query($res)->result_array();

       // var_dump($query);die;
        if($query==NULL){
            $query= array();
        }
        return $query;
    }

    public function get_all_info($id){
        $qq = "SELECT * FROM coach,company WHERE coach.company_id=company.company_id AND coach.coach_id=$id";
        $query = $this->db->query($qq)->result_array();
        return $query;

    }
}