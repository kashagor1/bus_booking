<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Ticket Details</title>
    <!-- Add Bootstrap CSS link -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
        }

        .header h3 {
            margin: 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            text-align: left;
            font-weight: bold;
        }

        .table td {
            text-align: right;
        }

        .table th:first-child,
        .table td:first-child {
            width: 40%;
        }
    </style>

</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="ticket-header">
                        <h3 class="text-center">Ticket Info</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tbody>
                             
                               
                                <tr>
                                    <th>PNR:</th>
                                    <td><?php echo $info['pnr'];?></td>
                                </tr>
                                <tr>
                                    <th>Name:</th>
                                    <td><?php echo $info['name']?></td>
                                </tr>
                            
                                <tr>
                                    <th>Booking Date:</th>
                                    <td><?php echo $info['b_date']?></td>
                                </tr>
                                <tr>
                                    <th>Departure Date:</th>
                                    <td><?php echo $info['departure_date']?></td>
                                </tr>
                                <tr>
                                    <th>Source:</th>
                                    <td><?php echo $info['source']?></td>
                                </tr>
                                <tr>
                                    <th>Destination:</th>
                                    <td><?php echo $info['destination']?></td>
                                </tr>
                                <tr>
                                    <th>Phone Number:</th>
                                    <td><?php echo $info['phone_number']?></td>
                                </tr>
                                <tr>
                                    <th>Seats:</th>
                                    <td><?php echo $info['seats']?></td>
                                </tr>
                             
                                <tr>
                                    <th>Fare:</th>
                                    <td><?php
                                    $nums=  count(explode(",",$info['seats']));

                                    echo $info['fare']*$nums?></td>
                                </tr>
                              
                                <tr>
                                    <th>Coach Type:</th>
                                    <td><?php echo $info['coach_type']?></td>
                                </tr>
                                <tr>
                                    <th>Trip ID:</th>
                                    <td><?php echo $info['trip_id']?></td>
                                </tr>
                              
                                <tr>
                                    <th>Vehicle Number:</th>
                                    <td><?php echo $info['vehicle_number']?></td>
                                </tr>
                                <tr>
                                    <th>Supervisor Number:</th>
                                    <td><?php echo $info['supervisor_no']?></td>
                                </tr>
                               
                                <tr>
                                    <th>Departure:</th>
                                    <td><?php
                                 $formattedTime = date('g:i A', strtotime($info['departure']));

                                    echo $formattedTime?></td>
                                </tr>
                                <tr>
                                    <th>Arrival:</th>
                                    <td><?php
                                    
                                    $formattedTime = date('g:i A', strtotime($info['arrival']));

                                    
                                    echo $formattedTime?></td>                                </tr>
                                <tr>
                                    <th>Main Boarding:</th>
                                    <td><?php echo $info['main_boarding']?></td>
                                </tr>
                                <tr>
                                    <th>Final Destination:</th>
                                    <td><?php echo $info['final_destination']?></td>
                                </tr>
                              
                             
                                <!-- Add other rows for additional fields -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS link (required for Bootstrap functionality) -->
</body>

</html>
