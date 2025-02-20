<div class="container my-4">
<div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary section-with-background" style="margin-top: 20px;">
    <div class="row py-5">
      <div class="col-md-1"></div>
      <div class="col-md-10">
        <form action="search" method="get" class="my-form" id="bus-search-form">
                <div class="search-box" style="margin-top: 0px;">
                    <div class="d-flex align-items-center mb-3">
                        <input type="radio" name="trip_type" id="oneWay" value="oneWay" <?php if($trip_type == 'oneWay') echo 'checked';?>>
                        <label for="oneWay" class="ms-2">One Way</label>
                        <input type="radio" name="trip_type" id="roundWay" value="roundWay" <?php if($trip_type == 'roundWay') echo 'checked';?> class="ms-3">
                        <label for="roundWay" class="ms-2">Round Way</label>
                    </div>
                    <div class="row g-2 align-items-end">
                        <div class="col-md-3" style="position: relative;">
                            <label class="form-label">From</label>
                            <div class="input-group">
                                <input required type="text" value="<?=$or?>" class="form-control custom-input" placeholder="Enter City" name="origin" id="origin-input">
                            </div>
                            <div id="origin-search-results" class="search-results-container"></div>
                        </div>
                        <div class="col-md-3" style="position: relative;">
                            <label class="form-label">To</label>
                            <div class="input-group">
                                <input required type="text" value="<?=$ds?>" class="form-control custom-input" placeholder="Enter destination" name="destination" id="destination-input">
                            </div>
                            <div id="destination-search-results" class="search-results-container"></div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Journey Date</label>
                            <input required type="text" value=<?=$dt?> class="custom-input form-control" name="date" id="date-input" placeholder="Select Date">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Return Date</label>
                            <input type="text" class="custom-input form-control rdate_input" value="<?php if ($trip_type=='roundWay') echo $rt?>" name="rdate" id="rdate-input" placeholder="Select Date">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success w-100" type="submit">SEARCH</button>
                        </div>
                    </div>
                </div>
            </form>
      
      </div>
      <div class="col-md-1"></div>
    </div>


  </div>


  <div class="row g-5">
    <div class="col-md-3">
      <div class="position-sticky" style="top: 2rem;">
        <div class="p-4 mb-3 bg-body-tertiary rounded">
          <div class="companyType">
            <h4>Bus Companies</h4>
             <?php foreach($companies as $op):?>
            <label>
              <input type="checkbox" class="companyFilter" value="<?=$op?>"><?=$op?>
            </label>
            <?php endforeach; ?>
            <!-- Add more checkboxes for bus companies as needed -->
          </div>
          <div id="busTypeFilter">
            <h4>Bus Type</h4>
            <?php foreach($coach_types as $cp):?>
            <label>
              <input type="checkbox" class="busType" value="<?=$cp?>"><?=$cp?>
            </label>
            <?php endforeach; ?>
            <!-- Add more checkboxes for bus companies as needed -->
          </div>
          <div class="priceFilter">
            <h4>Price Range</h4>
            <label>
              Min Price:
              <input type="number" id="minPrice" min="0">
            </label>
            <label>
              Max Price:
              <input type="number" id="maxPrice" min="0">
            </label>
          </div>

        </div>
      </div>
    </div>
    <div class="col-md-9">

      <table class="table table-striped" id="busTable">
        <colgroup>
          <col style="width: 40%;">
          <col style="width: 12%;">
          <col style="width: 10%;">
          <col style="width: 20%;">
          <col style="width: 15%;">
        </colgroup>
        <thead style="border-bottom: 5px solid #F7F7F7; color: #828282;">
          <tr>
            <th class="tbl_th1 th_text_color header">
              Operator <span style="font-weight: normal;">(Bus Type)</span>
            </th>
            <th class="tbl_th3 header" style="color: #828282;">
              Dep. Time
            </th>
            <th class="tbl_th4 header" style="color: #828282;">
              Arr. Time
            </th>
            <th class="tbl_th5 header" style="color: #828282;">
              Seats Available
            </th>
            <th class="tbl_th6 header headerSortUp" style="color: #828282;">
              Fare
            </th>
          </tr>
        </thead>

        <tbody>
          <?php


          if ($result != 0) {
            $ri  = 1;
            foreach ($result as $trip) {
              $ri++;
             // var_dump($trip);die;
              ?>




              <tr class="trip-row">
                <td class="tbl_col1 border-fix-seat" data-title="Operator">

                  <ul>
                    <li class="op_name shohoz_green">
                      <p style="font-weight:600;margin-bottom: 0px;">
                        <?php echo $trip['company_name']; ?>
                        <span style="font-weight:400">
                          (
                          <?php echo $trip['coach_type']; ?>
                          )
                        </span>
                      </p>
                    <li class="bus_type"><b style="color:#757A7E;">Route:</b>

                      <?php


                      $dash_excuse = count($trip['or_route']);
                      $i = 1;
                      foreach ($trip['or_route'] as $rot) {
                        if ($i == $dash_excuse) {
                          echo $rot['route_name'];
                        } else {
                          echo $rot['route_name'] . " - ";
                        }
                        $i++;
                      }


                      ?>


                    </li>
                    <li><b style="color:#757A7E;">Starting Point:</b>
                      <?php echo $trip['main_boarding']; ?>
                    </li>
                    <li><b style="color:#757A7E;">Ending Point:</b>
                      <?php echo $trip['final_destination']; ?>
                    </li>
                    <!--//// For Eid  /////-->
                    <!--//// For Eid  /////-->


                  </ul>

                </td>
                <td class="tbl_col3 border-fix-seat" data-title="Dep. Time">
                  <?php
                  $dTime = date('h:i A', strtotime($trip['departure']));

                  echo $dTime; ?> <br>

                </td>
                <td class="tbl_col4 border-fix-seat" data-title="Arr. Time">
                  <?php
                                    $aTime = date('h:i A', strtotime($trip['arrival']));

                   echo $aTime; ?>
                </td>
                <td class="tbl_col5 border-fix-seat shohoz_green" data-title="Seats Available">
                  <?php
                  echo $trip['seat_layout'] - $trip['av_seats'];

                  ?>
                </td>
                <td class="tbl_col6 border-fix-seat" data-title="Fare" style="text-align:right;  position: relative;">

                  <ul class="list-inline fare-list">
                    <span>  ৳</span>
                    <li class="fare_li" style="text-align: right;float:none;">
                    
                      <?php



                      $price = $trip['final_fare'];




                      echo $price;


                      ?>



                    </li>



                  </ul>

                  <div class="clearfix"></div>
                     
              
<button type="button" id="viewseats" data-params='
                  { "company_name":"<?php echo $trip['company_name'];?>",
                    "origin":"<?php echo base64_encode($_GET['origin']);?>",
                    "destination":"<?php echo base64_encode($_GET['destination']); ?>",
                    "departure":"<?php echo $dTime;?>",
                    "arrival":"<?php echo $aTime;?>",
                    "coach_id":"<?php echo $trip['coach_id']?>",
                    "route_id":"<?php echo $trip['route_id']?>",
                    "fare":"<?php echo $trip['final_fare'];?>",
                    "date":"<?php echo $_GET['date']?>",
                    "trip_id":"<?php echo $trip['trip_id']?>",
                    "test_id":"<?php echo $ri; ?>"
                    }
                    
                    ' class="btn btn-danger btn-sm viewseats" data-bs-toggle="modal" data-bs-target="#exampleModal">
  View Seats
</button>
                </td>
              </tr>



              <?php
              // ... perform other operations
            }



          } 

          ?>

        </tbody>
      </table>
    </div>
  </div>

  </div>
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" >
      <div class="modal-header" id="seatModalHeader">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>  