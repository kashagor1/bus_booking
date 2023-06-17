<?php 


Class Login extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default',TRUE); 
        
    }
    public function checkUser($data){

        $query = $this->db->query("SELECT * FROM user WHERE username='$data[user_name]' AND password = md5('$data[password]')"); 
       echo "<pre>";
       
       return $query->row();
    }    
}