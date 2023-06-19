<?php 


Class Districts extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default',TRUE); 
        
    }
    public function getList(){

        $query = $this->db->query("SELECT * FROM district"); 
    //   echo "<pre>";
        $resultArray = $query->result_array();
    $jsonResult = json_encode($resultArray);

       echo $jsonResult;
       //return $query->row();
    }    
}