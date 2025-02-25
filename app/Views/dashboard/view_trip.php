

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

    
      
        <div class="row">
        <div class="col-12 d-flex justify-content-center py-3">

                <a href="<?php echo base_url()?>dashboard/trip/print_info?id=<?php echo $tr_id;?>&cid=<?php echo $co_id;?>"><button class="btn btn-info">Download Trip List</button></a>
                <a href="<?php echo base_url()."dashboard/trip/cancel?id=".$tr_id."&cid=".$co_id;?>">   <button class="btn btn-danger ml-3">Cancel</button></a>

            </div>
            <div class="col-1"></div>
            <div class="col-10">
              
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
                            <tr>
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
            <div class="col-1"></div>
        </div>
    </div>
</section>