<?php
$jsonData = json_decode($jsonResult, true);




?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <div class="modal fade" id="update_route" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="<?php echo base_url();?>dashboard/update_route_info">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Update Route</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-12">
                                    <label for="edit_r_name" class="form-label">Route Name</label>
                                    <input type="text" class="form-control" id="edit_r_name" placeholder="Dh.."
                                        name="r_name" required>
                                </div>
                                <div class="col-12">
                                    <label for="edit_r_fare" class="form-label">Fare</label>
                                    <input type="text" class="form-control" id="edit_r_fare"
                                        placeholder="500" name="r_fare" required>
                                </div>
                                <div class="col-12">
                                    <label for="edit_point_type" class="form-label">Select Destination Type</label>
                                    <select id="edit_point_type" name="destination_type" class="form-select" aria-label="Select an option">
                                    <option value="0">Main Boarding Point</option>
                                    <option value="2">Boarding Point</option>
                                    <option value="3">Dropping Point</option>
                                    <option value="1">Final Dropping Point</option>
                                </select>
                                    <input type="hidden" name="re_id" id="re_id" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" >Save changes</button>
                            </div>
                        </div>
</form>
                    </div>
                </div>


                <table id="rlist" class="table table-striped table-bordered table-sm" cellspacing="0"
                    width="100%">
                    <thead style="border-bottom: 5px solid #F7F7F7; color: #828282;">
                        <tr>
                            <th>
                                Route ID
                            </th>
                            <th>
                                Route Path
                            </th>
                             <th>
                                Fare
                            </th>
                             <th>
                                Route Type
                            </th>
                            <th>
                                Action
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($jsonData as $data) {

                            ?>
                            <tr>
                                <td>
                                    <?php echo $data['route_id']; ?>
                                </td>
                                <td>
                                    <?php echo $data['route_name'];?>
                                </td>
                                <td>
                                    <?php echo $data['fare'];?>
                                </td>
                                 <td>
                                    <?php

                                    switch ($data['point_type']) {
                                        case '0':
                                            echo "Main Boarding Point";
                                            break;
                                        case '2':
                                            echo "Boarding Point";
                                            break;
                                        case '3':
                                            echo "Dropping Point";
                                            break;
                                        
                                        default:
                                            echo "Final Dropping Point";
                                            break;
                                    }

                                    ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning update_route_info" data-bs-toggle="modal"
                                        data-bs-target="#update_route" c_id="<?php echo $data['id']?>">
                                        Update</button>

                                    <a href="<?php echo base_url()."dashboard/delete_route?id=".$data['id'];?>">   <button class="btn btn-sm btn-danger">Delete</button></a>

                                    <a href="<?php echo base_url()."dashboard/delete_w_route?id=".$data['route_id'];?>">   <button class="btn btn-sm btn-danger">Delete Full Route</button></a>
                                </td>


                            </tr>


                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
</section>