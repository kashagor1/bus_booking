<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">

                <form class="row g-3" method="POST" action="<?php echo base_url()?>dashboard/update_route" id="section-form">
                <div class="col-6">
                        <label for="inputAddress" class="form-label">Route ID</label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="<?php echo $results[0]['route_id']?>" name="route_id" disabled
                            required>
                    </div>
                    <div class="col-6">
                        <label for="inputAddress2" class="form-label">Company ID</label>
                        <input type="text" class="form-control" id="inputAddress2" placeholder="<?php echo $results[0]['company_id']?>" name="company_id"disabled
                            required>
                    </div>
                    <div class="col-12">
                    <div class="row" style="font-size:15px;font-weight:600;text-align:center">
                        <div class="col-4">
                            <p>Route Name</p>
                        </div>
                        <div class="col-2">
                             <p>Order ID</p>
                        </div>
                        <div class="col-2">
                        <p>Fare Adjustment</p>
                        </div>
                        <div class="col-4">

                        <p>Point Type</p>

                        </div>
                       
                    </div>

                    <?php
                    // Fetch the data from the database
                 
    foreach ($results as $row) {
        $routeName = $row['route_name'];
        $fare = $row['fare'];
        $destinationType = $row['point_type'];
        $orid = $row['or_id'];
        ?>

    

<div class="col-12 section-container">

                                <div class="row">
                                    <div class="col-4">
                                    <input type="hidden" name="id[]" value="<?php echo $row['id']?>">
                                    <input type="hidden" name="route_id[]" value="<?php echo $row['route_id']?>">

                                        <input type="text" name="route_name[]" class="form-control" value="<?php echo $routeName; ?>">
                                        <div id="route_input_a_result"></div>

                                    </div>
                                    <div class="col-2">
                                        <input type="number" class="form-control" name="or_id[]"  value="<?php echo $orid; ?>">
                                    </div>
                                    <div class="col-2">
                                        <input type="number" name="fare[]" class="form-control" value="<?php echo $fare; ?>">
                                    </div>
                                    <div class="col-4">
                                        <select name="destination_type[]" class="form-control" aria-label="Select an option">
                                            <option value="0" <?php if ($destinationType == 0) echo "selected"; ?>>Main Boarding Point</option>
                                            <option value="2" <?php if ($destinationType == 2) echo "selected"; ?>>Boarding Point</option>
                                            <option value="3" <?php if ($destinationType == 3) echo "selected"; ?>>Dropping Point</option>
                                            <option value="1" <?php if ($destinationType == 1) echo "selected"; ?>>Final Dropping Point</option>
                                        </select>
                                    </div>
                                  
                                </div>
</div>
                            <?php
                        }
                    
                    ?>

                    </div>
                    <div class="col-12 py-3">
                        <div class="text-center">
                            <button type="submit" class="btn btn-warning">Upadte Route</button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-2"></div>
        </div>
    </div>
</section>
