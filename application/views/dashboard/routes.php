<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">

                <form class="row g-3" method="POST" action="<?php echo base_url()?>dashboard/create_route" id="section-form">
                    <div class="col-6">
                        <label for="inputAddress" class="form-label">Route ID</label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="1" name="route_id"
                            required>
                    </div>
                    <div class="col-6">
                        <label for="inputAddress2" class="form-label">Company ID</label>
                        <input type="text" class="form-control" id="inputAddress2" placeholder="1" name="company_id"
                            required>
                    </div>
                    <div class="col-12 section-container">
                        <div class="row">
                            <div class="col-4">
                                <input type="text" name="route_name[]" class="form-control">
                            </div>
                            <div class="col-2">
                                <input type="number" name="fare[]" class="form-control">
                            </div>
                            <div class="col-4">
                                <select name="destination_type[]" class="form-select" aria-label="Select an option">
                                    <option selected>Select Destination Type</option>
                                    <option value="0">Main Boarding Point</option>
                                    <option value="2">Boarding Point</option>
                                    <option value="3">Dropping Point</option>
                                    <option value="1">Final Dropping Point</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <div class="text-center">
                                    <button type="button" class="add-section btn btn-sm btn-primary">+</button>
                                    <button type="button" class="remove-section btn btn-sm btn-danger">-</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 py-3">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">ADD</button>
                        </div>
                    </div>
                </form>


            </div>
            <div class="col-2"></div>


        </div>
    </div>
</section>