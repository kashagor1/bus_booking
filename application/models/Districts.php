<?php 


Class Districts extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default',TRUE); 
        
    }
    public function getList(){

        $query = $this->db->query("SELECT district_name FROM district"); 
    //   echo "<pre>";
        $resultArray = $query->result_array();
    $jsonResult = json_encode($resultArray);

       echo $jsonResult;
       //return $query->row();
    } 

    public function get_all_roi($id){

        $data = array();
       
        
        $q = "SELECT route_name FROM routes WHERE route_id='$id' and point_type=0";
        $qq = "SELECT route_name,fare,company_id FROM routes WHERE route_id='$id' and point_type=1";
        $query = $this->db->query($q);
        $resultA = $query->result_array();
       
       $data['main_boarding'] = $resultA[0]['route_name'];

        $query = $this->db->query($qq);
        $rss = $query->result_array();
        $data['final_destination']=$rss[0]['route_name'];
        $data['total_fare']=$rss[0]['fare'];
        $data['company_id']=$rss[0]['company_id'];


        
$jsonR = json_encode($data);
        echo $jsonR;
    //     $query = $this->db->query("SELECT * FROM routes"); 
    // //   echo "<pre>";
    //     $resultArray = $query->result_array();
    // $jsonResult = json_encode($resultArray);

    //    echo $jsonResult;
       //return $query->row();
    } 

}