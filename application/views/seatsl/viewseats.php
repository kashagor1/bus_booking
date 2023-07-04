<div class="row card" style="backgroud:red;">

    <div class="col-lg-12 py-5" style="text-align:center;">
        <h1>
            <?php echo $info['company_name']; ?>
        </h1>
    </div>
    <div class="col-lg-12" style="text-align:center;">
        <h4>
            <?php echo $info['main_boarding'] . ' - ' . $info['final_destination']; ?>
        </h4>
    </div>
    <div class="col-lg-12 text-center py-3">
        <h6>

            <?php
            $i = 0;
            foreach ($froute as $rt) {
                echo $rt['route_name'];
                if ($i != count($froute) - 1) {
                    echo " - ";
                }
                $i++;
            }



            $dTime = date('h:i A', strtotime($info['departure']));
            $aTime = date('h:i A', strtotime($info['arrival']));


            ?>

        </h6>
    </div>
    <div class="col-12 py-3" style="font-weight:600;font-size:1rem;color:gray">
        <div class="row">
            <div class="col">
                <h6 class="text-start">Departure: <?php echo $dTime;?></h6>
            </div>
            <div class="col">
                <h6 class="text-end">Arrival: <?php echo $aTime;?> </h6>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-6">
    </div>
    <div class="col-6"></div>
</div>

<!-- <h2>Seat Selection</h2>

  <div class="bus-layout">
    <?php
    // $rows = range('A', 'J');
    // $columns = 4;
    // $totalSeats = count($rows) * $columns;
    // $seatCounter = 1;
    
    // foreach ($rows as $row) {
    //   for ($column = 1; $column <= $columns; $column++) {
    //     $seatLabel = $row . $column;
    //     echo '<div class="seat" data-seat="' . $seatCounter . '">';
    //     echo '<span class="seat-label">' . $seatLabel . '</span>';
    //     echo '</div>';
    
    //     $seatCounter++;
    //   }
    // }
    ?>
  </div> -->