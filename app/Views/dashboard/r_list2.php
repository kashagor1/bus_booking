

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
                                Route ID
                            </th>
                             <th>
                                Company Name
                            </th>
                            <th>
                                Route Path
                            </th>
                             <th>
                                Fare
                            </th>
                            <th>
                                Action
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $sl=1;
                        foreach ($routes as $data) {
                           
                            ?>
                            <tr>
                                <td><?php echo $sl;?></td>
                                <td>
                                    <?php echo $data['id']; ?>
                                </td> 
                                <td>
                                    <?php echo $data['company_name']; ?>
                                </td>
                                <td>
                                    <?php echo $data['route_name']."-".$data['route_name2'];?>
                                </td>
                                <td>
                                    <?php echo $data['fare'];?>
                                </td>
                          
                                <td>
                                 <a href="<?php echo base_url()."dashboard/routes/view_full?id=".$data['id'];?>">   <button class="btn btn-sm btn-success">View Full Route</button></a>

                                    <a href="<?php echo base_url()."dashboard/routes/delete?id=".$data['id'];?>">   <button class="btn btn-sm btn-danger">Delete</button></a>

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