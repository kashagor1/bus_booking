<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">

                <form class="row g-3" method="POST" action="<?php echo base_url() ?>dashboard/routes/create"
                    id="section-form">
                    <div class="col-3">
                        <label for="inputAddress" class="form-label">Route ID</label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="1" name="route_id"
                            value="<?php echo $route_id + 1; ?>" required readonly>
                    </div>
                    <div class="col-4">
                        <label for="inputCompany" class="form-label">Company ID</label>
                        <input type="text" class="form-control" value="<?php echo isset($com_id) ? $com_id : "" ?>"
                            id="inputCompany" placeholder="1" name="company_id" <?php echo isset($com_id) ? "readonly" : "required" ?>>
                    </div>
                    <div class="col-5">
                        <label for="company_name" class="form-label">Company Name</label>
                        <input type="text" class="form-control" id="company_name" placeholder="Company Name"
                            name="company_name" value="<?php echo isset($company_name) ? $company_name : "" ?>" required
                            readonly>
                    </div>
                    <div class="col-12">
                        <div class="row py-1" style="text-align:center;">
                            <div class="col-3">
                                <h6>Route Name</h6>
                            </div>
                            <div class="col-2">
                                <h6>Order ID</h6>
                            </div>
                            <div class="col-2">
                                <h6>Fare Adjustment</h6>
                            </div>
                            <div class="col-3">

                                <h6>Point Type</h6>

                            </div>
                            <div class="col-2">
                                <h6>Action</h6>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 ">
                        <div class="row section-container py-1" id="parent_input">
                            <div class="col-3">
                                <input type="text" name="route_name[]" class="form-control" id="route_input" required>
                                <div id="route_input_a_result"></div>
                            </div>
                            <div class="col-2">
                                <input type="number" class="form-control" name="or_id[]" required>
                            </div>
                            <div class="col-2">
                                <input type="number" name="fare[]" class="form-control" required>
                            </div>
                            <div class="col-3">
                                <select name="destination_type[]" class="form-control" aria-label="Select an option"
                                    required>
                                    <option selected>Select Destination Type</option>
                                    <option value="0">Main Boarding Point</option>
                                    <option value="2">Boarding Point</option>
                                    <option value="3">Dropping Point</option>
                                    <option value="1">Final Dropping Point</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <div class="text-center">
                                    <button type="button" id="add-section"
                                        class="add-section btn btn-sm btn-primary">+</button>
                                    <button type="button" class="remove-section btn btn-sm btn-danger">-</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 py-3">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">ADD ROUTE</button>
                        </div>
                    </div>
                </form>


            </div>
            <div class="col-2"></div>


        </div>
    </div>
</section>