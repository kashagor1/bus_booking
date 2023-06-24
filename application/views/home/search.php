<main class="container">
  <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
    <div class="row py-5">
      <div class="col-md-1"></div>
      <div class="col-md-10">
        <div class="card px-3">
          <div class="card-body">
            <div class="row">
              <form action="search" method="get" class="my-form ">
                <div class="col-md-3">
                  <div class="row">
                    <div class="col-2 d-flex align-items-center">
                      <div class="text-center">
                        <i class="sicon fa-solid fa-bus-simple"></i>
                      </div>
                    </div>
                    <div class="col-10">
                      <div class="d-flex flex-column">
                        <div class="flex-fill form_header">
                          Origin
                        </div>
                        <div class="flex-fill">
                          <input type="text" class="custom-input" name="origin" <?php if (!empty($_GET['origin']))
                            echo "value='" . $_GET['origin'] . "'"; ?> id="origin-input">

                          <!-- Placeholder for displaying search results -->
                          <div id="origin-search-results"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="row">
                    <div class="col-2 d-flex align-items-center">
                      <div class="text-center">
                        <i class="sicon fa-solid fa-bus-simple"></i>
                      </div>
                    </div>
                    <div class="col-10">
                      <div class="d-flex flex-column">
                        <div class="flex-fill form_header">
                          destination
                        </div>
                        <div class="flex-fill">
                          <input type="text" class="custom-input" name="destination" <?php if (!empty($_GET['origin']))
                            echo 'value="' . $_GET["destination"] . '";';
                          ?> id="destination-input">
                          <div id="destination-search-results"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="row">
                    <div class="col-2 d-flex align-items-center">
                      <div class="text-center">
                        <i class="sicon fa-solid fa-calendar-days"></i>
                      </div>
                    </div>
                    <div class="col-10">
                      <div class="d-flex flex-column">
                        <div class="flex-fill form_header">
                          Date
                        </div>
                        <div class="flex-fill">
                          <input type="date" class="custom-input" name="date" <?php if (!empty($_GET['origin']))
                            echo "value='" . $_GET['date'] . "'"; ?> id="date-input">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="text-center d-grid gap-2">
                    <button class="btn btn-warning  p-3 b_submit_button" type="submit">Search
                      Bus</button>
                  </div>

                </div>
              </form>

            </div>
          </div>
        </div>
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
            <label>
              <input type="checkbox" class="companyFilter" value="Ena"> Ena
            </label>
            <label>
              <input type="checkbox" class="companyFilter" value="Hanif">Hanif
            </label>
            <!-- Add more checkboxes for bus companies as needed -->
          </div>
          <div id="busTypeFilter">
            <h4>Bus Type</h4>
            <label>
              <input type="checkbox" class="busType" value="AC Premium">AC
            </label>
            <label>
              <input type="checkbox" class="busType" value="NON_AC">NON_AC
            </label>
            <label>
              <input type="checkbox" class="busType" value="Classic">Classic
            </label>
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
            foreach ($result as $trip) {

              ?>




              <tr class="trip-row">
                <td class="tbl_col1 border-fix-seat" data-title="Operator">

                  <ul>
                    <li class="op_name shohoz_green">
                      <p style="font-weight:600;margin-bottom: 0px;">
                        <?php echo $trip[0]['company_name']; ?>
                        <span style="font-weight:400">
                          (
                          <?php echo $trip[0]['coach_type']; ?>
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
                      <?php echo $trip[0]['main_boarding']; ?>
                    </li>
                    <li><b style="color:#757A7E;">Ending Point:</b>
                      <?php echo $trip[0]['final_destination']; ?>
                    </li>
                    <!--//// For Eid  /////-->
                    <!--//// For Eid  /////-->


                  </ul>

                </td>
                <td class="tbl_col3 border-fix-seat" data-title="Dep. Time">
                  <?php echo $trip[0]['departure']; ?> <br>

                </td>
                <td class="tbl_col4 border-fix-seat" data-title="Arr. Time">
                  <?php echo $trip[0]['arrival']; ?>
                </td>
                <td class="tbl_col5 border-fix-seat shohoz_green" data-title="Seats Available">
                  <?php
                  echo $trip[0]['seat_layout'] - $trip['av_seats'];

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

                  <button type="submit" id="10650760" triproute="54918354" operatorid="129" tocity="Rangpur"
                    class="btn btn-danger btn-sm btnSubmit seatsLayout">
                    View Seats

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

</main>