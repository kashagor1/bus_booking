<?php


class Route extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->db = $this->load->database('default', TRUE);

  }

  public function get_route()
  { 
    $res= $this->db->query('SELECT max(route_id)  as route_id FROM routes')->result_array();
   
    return $res[0]['route_id'];
  }
  public function cr_route($data)
  {

    $rid = $data['route_id'];
    $cid = $data['company_id'];
    $rnames = $data['route_name'];
    $rfares = $data['fare'];
    $rtypes = $data['destination_type'];
    $or_id = $data['or_id'];

    for ($i = 0; $i < count($rnames); $i++) {
      $name = str_replace("'", "''", $rnames[$i]);
      $qq = "INSERT INTO routes (route_id, company_id,or_id, route_name,fare,point_type)
           VALUES ('$rid', '$cid',$or_id[$i], '$name','$rfares[$i]','$rtypes[$i]')";
      $this->db->query($qq);
    }
    return true;

  }
  public function list_routes()
  {
    $query = $this->db->query("SELECT * FROM routes ORDER BY route_id DESC");
    //   echo "<pre>";
    $resultArray = $query->result_array();
    $jsonResult = json_encode($resultArray);

    return $jsonResult;
  }
  public function get_r_info($id)
  {
    $qq = "SELECT * FROM routes where id='$id'";
    // echo $qq;die;
    $query = $this->db->query($qq)->result_array();
    return $query;

  }
  public function up_r($data)
  {

    $qq = "UPDATE routes set $data[field]='$data[val]' where id=$data[id]";
    $query = $this->db->query($qq);

  }
  public function del_route($id)
  {

    $this->db->query("DELETE FROM routes WHERE route_id=$id");


  }
  public function del_w_route($id)
  {

    $qq = "DELETE FROM routes WHERE route_id =$id";
    $this->db->query($qq);

  }


  public function get_full_route($id)
  {

    $query = $this->db->query("SELECT * FROM routes WHERE route_id = $id ORDER BY or_id ASC");
    //print_r ($query);die;
    return $query->result_array();

  }


  public function update_bulk_route($data)
  {

    $name = str_replace("'", "''", $data['route_name']);
    $query = "UPDATE routes SET route_name = '$name', or_id = '$data[or_id]', fare = '$data[fare]', point_type = '$data[point_type]' WHERE id = '$data[id]' ";
    $this->db->query($query);
    // $affectedRows = $this->db->affected_rows();
    // if ($affectedRows == 0) {
    //   $qq = "INSERT INTO routes (route_id, company_id,or_id, route_name,fare,point_type)
    //        VALUES ('$data[route_id]', '$data[company_id]',$data[or_id], '$name','$data[fare]','$data[point_type]')";
    //   $this->db->query($qq);
    // }

  }
  public function update_coach($data)
  {
    $name = str_replace("'", "''", $data['route_name']);
    if ($data['point_type'] == 0) {
      $query = "UPDATE coach SET main_boarding = '$name' WHERE route_id = '$data[route_id]' ";

    } else {
      $query = "UPDATE coach SET final_destination = '$name',total_fare='$data[fare]' WHERE route_id = '$data[route_id]' ";

    }
    $this->db->query($query);


  }


  public function list_routes2()
  {
    // Assuming you have established a database connection in CodeIgniter 3

    // Retrieve route IDs
    $query = $this->db->query("SELECT DISTINCT route_id AS id FROM routes ORDER BY route_id DESC");

    if ($query->num_rows() > 0) {
      $routes = array();

      // Iterate over the results
      foreach ($query->result() as $row) {
        $id = $row->id;

        // Query route information with point_type = 0
        $query1 = $this->db->query("SELECT route_name FROM routes WHERE route_id='$id' AND point_type=0");
        $row1 = $query1->row();
        $routeName = $row1->route_name;

        // Query route information with point_type = 1
        $query2 = $this->db->query("SELECT route_name, fare FROM routes WHERE route_id='$id' AND point_type=1");
        $row2 = $query2->row();
        $routeName2 = $row2->route_name;
        $fare = $row2->fare;

        // Store the results in an array
        $routeInfo = array(
          'id' => $id,
          'route_name' => $routeName,
          'route_name2' => $routeName2,
          'fare' => $fare
        );

        // Add the route information to a multidimensional array
        $routes[] = $routeInfo;
      }

      // Print the array containing the route information
      return $routes;
    }


  }

}