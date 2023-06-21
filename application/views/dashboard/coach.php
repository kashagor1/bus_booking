<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">

                <form class="row g-3" method="POST" action="<?php echo base_url()?>dashboard/create_coach">


                    <div class="col-3">
                        <label for="com_id" class="form-label">Compnay ID</label>
                        <input type="text" class="form-control" id="company_id" placeholder="1"
                            name="company_id" required readonly>
                    </div>
                    <div class="col-3">
                        <label for="cc_route_id" class="form-label">Route ID </label>
                        <input type="text" class="form-control" id="cc_route_id" placeholder="1"
                            name="cc_route_id" required>
                    </div>
                    <div class="col-6">
                        <label for="coach_type" class="form-label">Coach Type </label>
                        <input type="text" class="form-control" id="coach_type" placeholder="AC/NON-AC/SLEEPER"
                            name="coach_type" required>
                    </div>
                    <div class="col-6">
                        <label for="vehicle_number" class="form-label">Vehicle Number </label>
                        <input type="text" class="form-control" id="vehicle_number" placeholder="Dhaka KA 12-1111"
                            name="vehicle_number" required>
                    </div>
                    <div class="col-6">
                        <label for="supervison_no" class="form-label">Supervison Number </label>
                        <input type="text" class="form-control" id="supervison_no" placeholder="01711111111"
                            name="supervisor_no" required>
                    </div>
                    <div class="col-4">
                        <label for="seat_layout" class="form-label">Seat Layout </label>
                        <input type="text" class="form-control" id="seat_layout" placeholder="36/40/55"
                            name="seat_layout" required>
                    </div>
                    <div class="col-4">
                        <label for="departure" class="form-label">Departure </label>
                        <input type="text" class="form-control" id="departure" placeholder="12"
                            name="departure" required>
                    </div>
                    <div class="col-4">
                        <label for="arrival" class="form-label">Arrival </label>
                        <input type="text" class="form-control" id="arrival" placeholder="12"
                            name="arrival" required>
                    </div>

                    <div class="col-4">
                        <label for="main_boarding" class="form-label">Main Boarding </label>
                        <input type="text" class="form-control" id="main_boarding" placeholder="Dhaka"
                            name="main_boarding" required readonly >
                    </div>
                    <div class="col-4">
                        <label for="final_destination" class="form-label">Final Destination </label>
                        <input type="text" class="form-control" id="final_destination" placeholder="Rangpur"
                            name="final_destination" required readonly >
                    </div>
                    <div class="col-4">
                        <label for="total_fare" class="form-label">Total Fare </label>
                        <input type="text" class="form-control" id="total_fare" placeholder="500"
                            name="total_fare" required readonly>
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
