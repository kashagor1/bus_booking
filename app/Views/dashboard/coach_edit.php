
<?php 

$departureTime = date("H:i", strtotime($info['departure']));
$arrivalTime = date("H:i", strtotime($info['arrival']));

?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">

                <form class="row g-3" method="POST" action="<?php echo base_url()?>dashboard/coach/update">


                    <div class="col-3">
                        <label for="com_id" class="form-label">Coach ID</label>
                        <input type="text" class="form-control" placeholder="1"
                            name="coach_id" value="<?php echo $coach_id;?>" required readonly>
                    </div>
                    <div class="col-3">
                        <label for="cc_route_id" class="form-label">Route ID </label>
                        <input type="text" class="form-control" id="cc_route_id" placeholder="1"
                            name="cc_route_id" value="<?php echo $info['route_id']?>" required>
                    </div>
                    <div class="col-6">
                        <label for="coach_type" class="form-label">Coach Type </label>
                        <input type="text" class="form-control" id="coach_type" placeholder="AC/NON-AC/SLEEPER"
                            name="coach_type" value="<?php echo $info['coach_type']?>" required>
                    </div>
                    <div class="col-6">
                        <label for="vehicle_number" class="form-label">Vehicle Number </label>
                        <input type="text" class="form-control" id="vehicle_number" placeholder="Dhaka KA 12-1111"
                            name="vehicle_number" value="<?php echo $info['vehicle_number']?>" required>
                    </div>
                    <div class="col-6">
                        <label for="supervison_no" class="form-label">Supervison Number </label>
                        <input type="text" class="form-control" id="supervison_no" placeholder="01711111111"
                            name="supervisor_no"  value="<?php echo $info['supervisor_no']?>" required>
                    </div>
                    <div class="col-3">
                        <label for="seat_layout_row" class="form-label">Seat Layout Row </label>
                        <input type="text" class="form-control" id="seat_layout_row" value="<?php echo $info['seat_row']?>" placeholder="9/10/11"
                            name="seat_layout_row" required>
                    </div>
                    <div class="col-3">
                        <label for="seat_layout_column" class="form-label">Seat Layout Column</label>
                        <input type="text" class="form-control" id="seat_layout_column" value="<?php echo $info['seat_column']?>" placeholder="3/4/5"
                            name="seat_layout_column" required>
                    </div>
                    <div class="col-3">
                        <label for="departure" class="form-label">Departure </label>
                        <input type="time" class="form-control" id="departure" placeholder="12"
                            name="departure" value="<?php echo $departureTime?>" required>
                    </div>
                    <div class="col-3">
                        <label for="arrival" class="form-label">Arrival </label>
                        <input type="time" class="form-control" id="arrival" placeholder="12"
                            name="arrival" value="<?php echo $arrivalTime?>" required>
                    </div>

                    <div class="col-4">
                        <label for="main_boarding" class="form-label">Main Boarding </label>
                        <input type="text" class="form-control" id="main_boarding" placeholder="Dhaka"
                            name="main_boarding" value="<?php echo $info['main_boarding']?>" required readonly >
                    </div>
                    <div class="col-4">
                        <label for="final_destination" class="form-label">Final Destination </label>
                        <input type="text" class="form-control" id="final_destination" placeholder="Rangpur"
                            name="final_destination" value="<?php echo $info['final_destination']?>" required readonly >
                    </div>
                    <div class="col-4">
                        <label for="total_fare" class="form-label">Total Fare </label>
                        <input type="text" class="form-control" id="total_fare" placeholder="500"
                            name="total_fare" value="<?php echo $info['total_fare']?>" required readonly>
                    </div>




                    <div class="col-12 py-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <div class="col-2"></div>


        </div>
    </div>
</section>
