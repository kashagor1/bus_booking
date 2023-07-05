
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row p-2">
        <h4 class="text-center">Refunded Tickets</h4>
    </div>
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
              
                <table id="rlist" class="table table-striped table-bordered table-sm" cellspacing="0"
                    width="100%">
                    <thead style="border-bottom: 5px solid #F7F7F7; color: #828282;">
                        <tr>
                            <th>Sl</th>
                            <th>
                               PNR
                            </th>
                            <th>
                                AMOUNT
                            </th>
                             <th>
                                FROM
                            </th>
                            <th>
                                TO
                            </th>
                            <th>
                                REFUND NUMBER
                            </th>
                            <th>
                                ACTION
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $sl=1;
                        foreach ($refunds as $data) {
                           
                            ?>
                            <tr>
                                <td><?php echo $sl;?></td>
                                <td>
                                    <?php echo $data['pnr']; ?>
                                </td>
                                <td>
                                    <?php echo $data['amount'];?>
                                </td>
                                <td>
                                    <?php echo $data['origin'];?>
                                </td>
                                <td>
                                    <?php echo $data['destination'];?>
                                </td>
                                <td>
                                    <?php echo $data['bkash'];?>
                                </td>
                                <td>
                        <a href="<?php echo base_url().'dashboard/sendref?pnr='.$data['pnr'];?>">  <button class="btn btn-primary btn-sm">Refund</button></a>
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
