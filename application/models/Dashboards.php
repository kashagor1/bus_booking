<?php


/**
 * Summary of Dashboard
 */
class Dashboards extends CI_Model
{
  
  public function __construct()
  {
    parent::__construct();
    $this->db = $this->load->database('default', TRUE);

  }

  public function create_company($data)
  {
    $query = "INSERT INTO `company` (`company_id`, `company_name`, `company_phone`, `company_address`) VALUES (NULL, '$data[company_name]', '$data[company_phone]', '$data[company_address]')";
    if ($this->db->simple_query($query)) {
     return "Sucess";
    }
    return "Error";
  }
  public function list_company(){
    $query = $this->db->query("SELECT * FROM company"); 
    //   echo "<pre>";
      $resultArray = $query->result_array();
      $jsonResult = json_encode($resultArray);

       return $jsonResult;
  } 
  public function get_c_info($id){
    $qq = "SELECT * FROM company where company_id='$id'";
   // echo $qq;die;
    $query = $this->db->query($qq)->result_array();
    return $query;

  }

  public function update_c_info($id,$data){

    
    $qq= "UPDATE company SET company_name='$data[company_name]',company_phone='$data[company_phone]',company_address='$data[company_address]' where company_id='$data[company_id]'";
    if($this->db->query($qq)){
      return "Success";
    }
    return "Fail";

  }
  public function delete_company($id){
    $this->db->where('company_id', $id);
    $this->db->delete('company');

  }

}