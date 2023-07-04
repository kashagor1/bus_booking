<?php 


Class Coaach extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default',TRUE); 
        
    }

    public function get_info($id){
       $res =  $this->db->query("SELECT * FROM coach WHERE coach_id=$id")->result_array()[0];
       return $res;
    } 
    public function delete_coach($id){
        $res =  $this->db->query("DELETE FROM `coach` WHERE coach_id=$id");
        return true;
     
     } 
    public function update_coach($data){
        $oname = str_replace("'","''",$data['main_boarding']);
        $dname = str_replace("'","''",$data['final_destination']);
        $ts= $data['seat_layout_row']*$data['seat_layout_column'];

        $qq = "UPDATE coach SET route_id='$data[cc_route_id]', coach_type='$data[coach_type]', seat_row='$data[seat_layout_row]',  seat_column='$data[seat_layout_column]',vehicle_number='$data[vehicle_number]', supervisor_no='$data[supervisor_no]', seat_layout='$ts', departure='$data[departure]', arrival='$data[arrival]', main_boarding='$oname', final_destination='$dname', total_fare='$data[total_fare]' WHERE coach_id='$data[coach_id]'";
     //  echo $qq;die;
        if($this->db->query($qq)){
            return true;
        }else{
            return false;
        }
    
    }  

}