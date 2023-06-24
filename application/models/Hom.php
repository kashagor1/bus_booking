<?php


class Hom extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);

    }

    public function get_routes($in)
    {

        $in_or = str_replace("'", "''", $in['origin']);
        $in_ds = str_replace("'", "''", $in['destination']);
        $qq = "SELECT DISTINCT route_id
        FROM coach
        WHERE route_id IN (
            SELECT route_id
            FROM routes
            WHERE route_name = '$in_or'
                AND route_id IN (
                    SELECT route_id
                    FROM routes
                    WHERE route_name = '$in_ds'
                        AND point_type IN (1, 3)
                )
                AND point_type IN (0, 2)
        )
        ORDER BY route_id ASC";
        $res = $this->db->query($qq)->result_array();

        return $res;


    }
    public function or_route($id)
    {
        $qq = "SELECT route_name FROM routes WHERE route_id=$id ORDER BY or_id ASC";
        $res = $this->db->query($qq)->result_array();
        return $res;
    }

    public function no_av_seats($id)
    {
        $qq = "SELECT * FROM seats WHERE coach=$id AND status='booked'";
        $res = $this->db->query($qq)->num_rows();

        return $res;

    }
    public function get_fare($data)
    {

        $qqqq = "SELECT * FROM routes WHERE  route_id='$data[rid]' AND point_type = 1 ";
        $dddd = $this->db->query($qqqq)->row();
        $final_price = $dddd->fare;
        //echo $dddd->route_name;
        $dname = str_replace("''", "'", $data['destination']);
        if ($dddd->route_name == $dname) {
            $qq = "SELECT * FROM routes WHERE route_name='$data[origin]' AND route_id='$data[rid]' AND point_type IN (0,2)";
            $dd = $this->db->query($qq)->row();
            $final_price -= $dd->fare;
            //echo $final_price;
        } else {
            $qq = "SELECT * FROM routes WHERE route_name='$data[origin]' AND route_id='$data[rid]' AND point_type IN (0,2)";
            $dd = $this->db->query($qq)->row();
            $op = $dd->fare;
            $qqq = "SELECT * FROM routes WHERE route_name='$data[destination]' AND route_id='$data[rid]' AND point_type IN (1,3)";
            $ddd = $this->db->query($qqq)->row();
            $dp = $ddd->fare;

            $final_price = $final_price - $op - $dp;
            //echo $data['destination']."-".$op."-".$dp;
        }
        return $final_price;
    }
    public function get_bus($in)
    {
        $routes = $this->get_routes($in);
        $dname = str_replace("'", "''", $in['destination']);
        $oname = str_replace("'", "''", $in['origin']);
        $result = array();
        if (count($routes) > 0) {
            foreach ($routes as $row) {
                $list = "SELECT * FROM routes, company, coach,trips
                WHERE coach.route_id = routes.route_id
                AND company.company_id = routes.company_id
                AND trips.coach_id = coach.coach_id
                AND routes.route_name='$dname' AND trips.departure_date='$in[date]' AND routes.route_id =$row[route_id]";
                //   echo $list;die;
                $query = $this->db->query($list);
                $res = $query->result_array();
                $cids = $query->row();
                // echo $list."<br>";
                $cid = $cids->coach_id;

                $price_check = array(
                    'origin' => $oname,
                    'destination' => $dname,
                    'rid' => $row['route_id']
                );
                $res['final_fare'] = $this->get_fare($price_check);
                $res['or_route'] = $this->or_route($row['route_id']);
                $res['av_seats'] = $this->no_av_seats($cid);
                $result[] = $res;
            }
            return $result;
        } else {
            return 0;
        }

    }
}