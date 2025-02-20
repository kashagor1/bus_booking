<div class="container">
    <div class="row py-3">
        <div class="col-12 text-center">
            <h3>Please fill paseenger information in the form bellow</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form method="POST" action="payment" class="row g-3">
                <h5> <?php echo $bookingData['origin'].' - '.$bookingData['destination'].' on '.$bookingData['date']?> </h5>
                <?php
                // var_dump($returnBookingData); die; // Remove or comment this line in production
                if (isset($bookingData['selected_seats']) && is_array($bookingData['selected_seats'])) {
                    foreach ($bookingData['selected_seats'] as $seat_no) {
                        ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name_<?php echo $seat_no; ?>">Name:</label>
                                <input type="text" class="form-control" name="name[]" id="name_<?php echo $seat_no; ?>" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="gender_<?php echo $seat_no; ?>">Gender:</label>
                                <select class="form-control" name="gender[]" id="gender_<?php echo $seat_no; ?>" required>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="seat_<?php echo $seat_no; ?>">Seat Number:</label>
                                <input type="text" class="form-control" name="seat[]" id="seat_<?php echo $seat_no; ?>" value="<?php echo $seat_no; ?>" readonly>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No seats selected.</p>";
                }
                ?>
                <?php if (isset($returnBookingData['selected_seats']) && is_array($returnBookingData['selected_seats'])) {?>
                <h5> <?php echo $returnBookingData['origin'].' - '.$returnBookingData['destination'].' on '.$returnBookingData['date']?> </h5>
                <?php
                // var_dump($returnBookingData); die; // Remove or comment this line in production
                    foreach ($returnBookingData['selected_seats'] as $seat_no) {
                        ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name_<?php echo $seat_no; ?>">Name:</label>
                                <input type="text" class="form-control" name="rname[]" id="name_<?php echo $seat_no; ?>" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="gender_<?php echo $seat_no; ?>">Gender:</label>
                                <select class="form-control" name="rgender[]" id="gender_<?php echo $seat_no; ?>" required>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="seat_<?php echo $seat_no; ?>">Seat Number:</label>
                                <input type="text" class="form-control" name="rseat[]" id="seat_<?php echo $seat_no; ?>" value="<?php echo $seat_no; ?>" readonly>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No return seats selected.</p>";
                }
                ?>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>