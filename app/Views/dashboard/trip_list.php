

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
                                Trip ID
                            </th>
                            <th>
                                Bus No
                            </th>
                            <th>
                               Date
                            </th>
                             <th>
                                Origin
                            </th>
                            <th>
                                Destination
                            </th>
                            <th>
                                Departure
                            </th>
                            <th>
                               Departure
                            </th>
                            <th>
                                Action
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $sl=1;
                        foreach ($trips as $data) {
                           
                            ?>
                            <tr>
                                <td><?php echo $sl;?></td>
                                <td><?php echo $data['id']; ?></td>
                                <td><?php echo $data['bus_no']; ?></td>
                                <td><?php echo $data['date']; ?></td>
                                <td><?php echo $data['origin']; ?></td>
                                <td><?php echo $data['destination']; ?></td>
                                <td><?php
                                
                                $time = date("h:iA", strtotime($data['departure']));

                                echo $time; ?></td>
                                <td><?php  $time = date("h:iA", strtotime($data['arrival']));

echo $time; ?></td>
                       
                               
                                
                                <td>
                                 <a href="<?php echo base_url()."dashboard/trip/view_info?id=".$data['id']."&cid=".$data['cid'];?>">   <button class="btn btn-sm btn-success">View All Info</button></a>

                                    <a href="<?php echo base_url()."dashboard/trip/cancel?id=".$data['id']."&cid=".$data['cid'];?>">   <button class="btn btn-sm btn-danger">Cancel</button></a>

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