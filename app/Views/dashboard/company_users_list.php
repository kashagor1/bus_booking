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
                <div class="modal fade" id="update_cuser" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="<?php echo base_url();?>dashboard/company/users/update">
                        <?= csrf_field() ?>

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body row">
                                <div class="col-6">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="number" name="uid" id="cuid" hidden>
                                    <input type="text" class="form-control " name="username" id="cusername" readonly>
                                </div>
                                <div class="col-6">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="text" class="form-control " name="registerPassword" id="cpassword">
                                </div>
                                <div class="col-6">
                                    <label for="role_type" class="form-label">Role Type</label>

                                    <select name="role_type" id="crole_type" class="form-control">
                                        <option value="100">Company Agent</option>                            
                                        <option value="110">Company Admin</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="fullname" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="fullName" id="cfullname">
                                </div>
                                <div class="col-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="number" class="form-control" name="phone" id="cphone">
                                </div>
                                <div class="col-6">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control"  name="email" id="cemail">
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
                                Username
                            </th>
                            <th>
                                Full Name
                            </th>
                            <th>
                                Phone Number
                            </th>
                            <th>
                                Role
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
                                    <?php echo $data['username']; ?>
                                </td>
                                <td>
                                    <?php echo $data['fullname']; ?>
                                </td>
                                  <td>
                                    <?php echo $data['phone']; ?>
                                </td>
                                <td>
                                    <?=$data['role']=='110'?"Admin":"Agent"?>
                                </td>
                              
                                <td>
                                    <button class="btn btn-sm btn-warning update_company_user_info" data-bs-toggle="modal"
                                        data-bs-target="#update_cuser" u_id="<?php echo $data['user_id']?>">
                                        Update</button>
                                    <a href="<?php echo base_url()."dashboard/company/delete_cuser?id=".$data['user_id'];?>">   <button class="btn btn-sm btn-danger">Delete</button></a>
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