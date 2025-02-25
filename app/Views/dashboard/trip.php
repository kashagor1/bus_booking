<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">

                <form class="row g-3" method="POST" action="<?php echo base_url()?>dashboard/trip/create">


                    <div class="col-3">
                        <label for="com_id" class="form-label">Trip ID</label>
                        <input type="text" class="form-control" id="trip_id" placeholder="1" value="<?php echo $trip_id;?> (Probable)"                          name="trip_id" required readonly>
                    </div>
                    <div class="col-3">
                        <label for="cc_route_id" class="form-label">Coach ID</label>
                        <input type="text" class="form-control" id="tcc_route_id" placeholder="1"
                            name="cc_route_id" required>
                    </div>
                    <div class="col-6">
                        <label for="trip_date" class="form-label">Trip Date</label>
                        <input type="date" class="form-control" id="trip_date" name="trip_date" required>
                    </div>
                    <div class="col-6">
                        <label for="vehicle_number" class="form-label">Vehicle Number </label>
                        <input type="text" class="form-control" id="vehicle_number" placeholder="Dhaka KA 12-1111"
                            name="vehicle_number" disabled>
                    </div>
                    <div class="col-6">
                        <label for="supervison_no" class="form-label">Supervison Number </label>
                        <input type="text" class="form-control" id="supervison_no" placeholder="01711111111"
                            name="supervisor_no" disabled>
                    </div>
                    <div class="col-4">
                        <label for="seat_layout" class="form-label">Seat Layout </label>
                        <input type="text" class="form-control" id="seat_layout" placeholder="36/40/55"
                            name="seat_layout" disabled>
                    </div>
                    <div class="col-4">
                        <label for="departure" class="form-label">Departure </label>
                        <input type="text" class="form-control" id="departure" placeholder="12"
                            name="departure" disabled>
                    </div>
                    <div class="col-4">
                        <label for="arrival" class="form-label">Arrival </label>
                        <input type="text" class="form-control" id="arrival" placeholder="12"
                            name="arrival" disabled>
                    </div>

                    <div class="col-4">
                        <label for="main_boarding" class="form-label">Main Boarding </label>
                        <input type="text" class="form-control" id="main_boarding" placeholder="Dhaka"
                            name="main_boarding" disabled  >
                    </div>
                    <div class="col-4">
                        <label for="final_destination" class="form-label">Final Destination </label>
                        <input type="text" class="form-control" id="final_destination" placeholder="Rangpur"
                            name="final_destination" disabled >
                    </div>
                    <div class="col-4">
                        <label for="total_fare" class="form-label">Total Fare </label>
                        <input type="text" class="form-control" id="total_fare" placeholder="500"
                            name="total_fare" disabled>
                    </div>




                    <div class="col-12 py-3">
                        <button type="submit" class="btn btn-primary">ADD</button>
                    </div>
                </form>
            </div>
            <div class="col-2"></div>


        </div>
    </div>
</section>
