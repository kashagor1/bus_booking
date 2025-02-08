<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Page</title>

    <style>
        body {
    margin: 0px;
}
.col-12.heading_company {
    text-align: center;
    font-size: 30px;
}
.row.trip_info {
    text-align: center;
}
        h4.col.hh {
    display: inline-block;
    height: 30px;
    width: 19%;
}
th {
    padding: 15px;
    text-align: center;
    color: white;
    border-right: 1px solid;
}

thead {
    background: #4ed7d7;
    /* color: white; */
}
tr.info {
    border-bottom: 1px solid black;
    font-weight: 600;
    /* padding: 30px; */
    height: 25px;
    text-align: center;
}
td {
    border-bottom: 1px solid gray;
    border-right: 0.5px solid gray;
}
    </style>

</head>

<body>
   


<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12 heading_company">
            <h1 class="text-center "><?php echo $coach['company_name'];?></h1>
            </div>
    </div>
        <div class="row trip_info">

            <h4 class="col hh">Trip No: <?php echo $tirp_no;?></h4>
            <h4 class="col hh">Supervisor No:<?php echo $coach['supervisor_no'];?></h4>
            <h4 class="col hh">Bus No:<?php echo $coach['vehicle_number'];?></h4>
            <h4 class="col hh">From: <?php echo $coach['main_boarding'];?></h4>
            <h4 class="col hh">To: <?php echo $coach['final_destination'];?></h4>
        </div>

      
        <div class="row">
            <div class="col-12">
              
                <table class="table table-striped table-bordered table-sm" cellspacing="0"
                    width="100%">
                    <thead style="border-bottom: 5px solid #F7F7F7; color: #828282;">
                        <tr>
                            <th>SL</th>
                            <th>
                                SEAT NO
                            </th>
                            <th>
                                PNR
                            </th>
                            <th>
                                PASSENGER NAME
                            </th>
                            <th>
                                PHONE NUMBER
                            </th>
                             <th>
                                ORIGIN
                            </th>
                            <th>
                                DESTINATION
                            </th>
                          

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $sl=1;
                        foreach ($seats as $data) {
                           
                            ?>
                            <tr class="info">
                                <td><?php echo $sl;?></td>
                                <td><?php echo $data['seat_no']; ?></td>
                                <td><?php echo $data['pnr']; ?></td>
                                <td><?php echo $data['passenger_name']; ?></td>
                                <td><?php echo $data['phone_number']; ?></td>
                                <td><?php echo $data['source']; ?></td>
                                <td><?php echo $data['destination']; ?></td>
                            </tr>


                        <?php $sl++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

</body>

</html>
