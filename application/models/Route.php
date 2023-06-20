<?php 


Class Route extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default',TRUE); 
        
    }

    public function get_route(){

    }
    public function cr_route($data){
        
        $rid = $data['route_id'];
        $cid = $data['company_id'];
        $rnames=$data['route_name'];
        $rfares=$data['fare'];
        $rtypes=$data['destination_type'];
        
        for ($i=0; $i < count($rnames) ; $i++) { 
           $qq = "INSERT INTO routes (route_id, company_id, route_name,fare,point_type)
           VALUES ('$rid', '$cid', '$rnames[$i]','$rfares[$i]','$rtypes[$i]')";
            $this->db->query($qq);
        }
       return true;
      
    }
    public function list_routes(){
    $query = $this->db->query("SELECT * FROM routes"); 
    //   echo "<pre>";
      $resultArray = $query->result_array();
      $jsonResult = json_encode($resultArray);

       return $jsonResult;
  }
   public function get_r_info($id){
    $qq = "SELECT * FROM routes where id='$id'";
   // echo $qq;die;
    $query = $this->db->query($qq)->result_array();
    return $query;

  }
  public function up_r($data){

    $qq=  "UPDATE routes set $data[field]='$data[val]' where id=$data[id]";
    $query=$this->db->query($qq);

  }
  public function del_route($id){

     $this->db->where('id', $id);
    $this->db->delete('routes');


  }
   public function del_w_route($id){

    $qq= "DELETE FROM routes WHERE route_id =$id";
    $this->db->query($qq);

  }
    
    
}