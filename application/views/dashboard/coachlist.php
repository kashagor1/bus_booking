

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
              
                <table id="rlist" class="table table-striped table-bordered table-sm" cellspacing="0"
                    width="100%">
                    <thead style="border-bottom: 5px solid #F7F7F7; color: #828282;">
                        <tr>
                            <th>Sl</th>
                            <th>
                                Coach ID
                            </th>
                            <th>
                                Route ID
                            </th>
                             <th>
                                Coach Type
                            </th>
                            <th>
                                Vehicle Number
                            </th>
                            <th>
                                Departure
                            </th>
                            <th>
                               Arrival
                            </th>
                            <th>
                               Origin
                            </th>
                            <th>
                                Destination
                            </th>
                            <th>
                                Total Fare
                            </th>
                            <th>
                                Action
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $sl=1;
                        foreach ($result as $data) {
                           
                            ?>
                            <tr>
                                <td><?php echo $sl;?></td>
                                <td><?php echo $data['coach_id']; ?></td>
                                <td><?php echo $data['route_id']; ?></td>
                                <td><?php echo $data['coach_type']; ?></td>
                                <td><?php echo $data['vehicle_number']; ?></td>
                                <td><?php
                                
                                $formattedTime = date('g:i A', strtotime($data['departure']));

                                echo $formattedTime; ?></td>
                                
                                <td><?php
                                
                                $formattedTime = date('g:i A', strtotime($data['arrival']));

                                echo $formattedTime; ?></td>
                                <td><?php echo $data['main_boarding']; ?></td>
                                <td><?php echo $data['final_destination']; ?></td>
                                <td><?php echo $data['total_fare']; ?></td>
                                
                                <td>
                                 <a href="<?php echo base_url()."dashboard/view_coach_info?id=".$data['coach_id'];?>">   <button class="btn btn-sm btn-success">View All Info</button></a>

                                    <a href="<?php echo base_url()."dashboard/delete_coach?id=".$data['coach_id'];?>">   <button class="btn btn-sm btn-danger">Delete</button></a>

                                </td>


                            </tr>


                        <?php $sl++; } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
</section>