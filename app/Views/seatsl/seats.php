<?php
// $coachiid = 6;
// $dbname = "newbus";
// $username = "root";
// $host = "localhost";
// $password = "";
// $conn = mysqli_connect($host, $username, $password, $dbname);

// // Define the number of rows and seats per row
// $numRows = 10;
// $numSeatsPerRow = 4;
// $maxSelection = 4;

// // Retrieve the selected seats from the URL parameter
// if (isset($_GET['bSeats']) && !empty($_GET['bSeats'])) {
//     $selectedSeats = $_GET['bSeats'];
// } else {

// }
?>


<div class="row">
    <div class="col-lg-6 seaList">


        <div class="seat-selection">
            <div class="seats-container">
                <table>
                    <tbody>
                        <?php


                        $row = $info['seat_row'];
                        $col = $info['seat_column'];
                        $sts = 1;
                        $selectedSeats = array();
                        for ($i = 1; $i <= $row; $i++) {
                            echo "<tr>";
                            $seat = chr($i + 64);
                            for ($j = 1; $j <= $col; $j++) {
                                echo "<td>";
                                $seatNo = $seat . $j;
                                $seatId = $sts;
                            
                                // $seatId = $results[$res - 1]['seat_id'];
                                // $seatNo = $results[$res - 1]['seat_no'];
                                //   $ccinfo = $results[$res - 1]['coach'];
                                $isSeatAvailable = !in_array($seatNo, array_column($results, 'seat_no')) && !in_array($seatId, $selectedSeats);

                                $st = $isSeatAvailable ? "available" : "unavailable";
                                $disabledAttribute = $isSeatAvailable ? "" : "disabled";
                                echo "<button id='$seatNo' class='seat $st' coachinfo='$coach_id' data-fare='$fare' $disabledAttribute>$seatNo</button>";
                                  echo "</td>";
                                if ($j == 2) {
                                    echo "<td></td>";
                                }
                                $sts++;
                            }
                            echo "</tr>";
                        }


                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">


        <h4>Selected Seats:</h4>
        <form id="selectionForm" method="POST" action="midform">
            <ul id="selectedSeatsList"></ul>
            <input type="hidden" name="coach_id" value="<?php echo $coach_id; ?>">
            <input type="hidden" name="fare" value="<?php echo $fare; ?>">
            <input type="hidden" name="origin" value="<?php echo $origin; ?>">
            <input type="hidden" name="destination" value="<?php echo $destination; ?>">
            <input type="hidden" name="trip_id" value="<?php echo $trip_id; ?>">
            <input type="hidden" name="route_id" value="<?php echo $route_id; ?>">
            <input type="hidden" name="date" value="<?php echo $date; ?>">
            <button type="submit" id="checkoutBtn">Checkout</button>
        </form>


    </div>
</div>