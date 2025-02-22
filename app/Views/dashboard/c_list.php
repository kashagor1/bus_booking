<?php
//  $jsonData = json_decode($jsonResult, true);

?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <div class="modal fade" id="update_company" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="<?php echo base_url();?>dashboard/update_company">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-12">
                                    <label for="edit_company_name" class="form-label">Comapne Name</label>
                                    <input type="text" class="form-control" id="edit_company_name" placeholder="Company Name"
                                        name="company_name" required>
                                </div>
                                <div class="col-12">
                                    <label for="edit_company_phone" class="form-label">Company Phone </label>
                                    <input type="text" class="form-control" id="edit_company_phone"
                                        placeholder="+8801234567891" name="company_phone" required>
                                </div>
                                <div class="col-12">
                                    <label for="edit_company_address" class="form-label">Company Address</label>
                                    <input type="text" class="form-control" id="edit_company_address" name="company_address"
                                        placeholder="124 Banani,Dhaka..." required>
                                    <input type="hidden" name="company_id" id="ce_id" required>
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


                <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0"
                    width="100%">
                    <thead style="border-bottom: 5px solid #F7F7F7; color: #828282;">
                        <tr>
                            <th>
                                Company ID
                            </th>
                            <th>
                                Comapny Name
                            </th>
                            <th>
                                Phone Number
                            </th>
                            <th>
                                Action
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($jsonResult as $data) {

                            ?>
                            <tr>
                                <td>
                                    <?php echo $data['company_id']; ?>
                                </td>
                                <td>
                                    <?php echo $data['company_name']; ?>
                                </td>
                                <td>
                                    <?php echo $data['company_phone']; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning update_company_info" data-bs-toggle="modal"
                                        data-bs-target="#update_company" c_id="<?php echo $data['company_id']?>">
                                        Update</button>
                                    <a href="<?php echo base_url()."dashboard/company/users/".$data['company_id'];?>">   <button class="btn btn-sm btn-secondary">Company Users</button></a>

                                    <a href="<?php echo base_url()."dashboard/delete_company?id=".$data['company_id'];?>">   <button class="btn btn-sm btn-danger">Delete</button></a>
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