<div class="container">
    <div class="row py-3">
        <div class="col-3"></div>
        <div class="col-6 text-center">
            <h3>Please Fill in the form</h3>
        </div>
        <div class="col-3"></div>
        <div class="col-12">
            <form method="POST" action="payment" class="row">
                <?php
                foreach ($selected_seats as $seat_no) {
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
                            <select class="form-control" name="gender[]"
                                id="gender_<?php echo $seat_no; ?>" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="seat_<?php echo $seat_no; ?>">Seat Number:</label>
                            <input type="text" class="form-control" name="seat[]"
                                id="seat_<?php echo $seat_no; ?>" value="<?php echo $seat_no; ?>" readonly>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>


        </div>
    </div>
</div>