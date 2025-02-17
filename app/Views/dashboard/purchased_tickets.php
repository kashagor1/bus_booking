

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
              
                <table id="Ticketlist" class="table table-striped table-bordered table-sm" cellspacing="0"
                    width="100%">
                    <thead style="border-bottom: 5px solid #F7F7F7; color: #828282;">
                        <tr>
                            <th>Sl</th>
                            <th>
                                PNR
                            </th>
                            <th>
                                Seats
                            <th>
                                Origin 
                            </th>
                            <th>
                               Destination
                            </th>
                             <th>
                                Fare
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $sl=1;
                        foreach ($tickets as $data) {
                           
                            ?>
                            <tr>
                                <td><?php echo $sl;?></td>
                                <td><?php echo $data['pnr']; ?></td>
                                <td><?php echo $data['seats']; ?></td>
                                <td><?php echo $data['source']; ?></td>
                                <td><?php echo $data['destination']; ?></td>
                                <td><?php echo $data['fare']; ?></td>
                            </tr>


                        <?php $sl++; } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
</section>