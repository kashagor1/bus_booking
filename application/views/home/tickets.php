<div class="container tcontainer">
    <div class="row p-2">
        <h4 class="text-center">Purchased Tickets</h4>
    </div>
    <div class="row">

        <div class="col-12 py-3">
        <?php 
                
                foreach($tickets as $ticket){
                 // var_dump($ticket);die;
                    $pnr = $ticket['pnr'];
                    $boarding=  $ticket['boarding'];
                    $destination=  $ticket['destination'];
                    $b_date=  $ticket['b_date'];
                    $j_date=  $ticket['j_date'];
                    $fare=  $ticket['fare'];
                    $seats = $ticket['seats'];
                    $seats = rtrim($seats, ',');
                    $num  = count(explode(',',$seats));
                  
                ?>
            <div class="card py-3 text-center">
              
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
              
                    <div class="col">
                        <h5><?php echo $boarding." - ".$destination?></h5>
                        <p><span>Purchase Date:</span> <?php echo $b_date?> </p>
                        <p><span>Journey Date:</span><?php echo $j_date?> </p>
                    </div>
                    <div class="col">
                        <h5><?php echo $seats;?></h5>
                    </div>
                    <div class="col">
                    <h5>Fare: <?php echo $fare*$num?></h5>

                    </div>
                    <div class="col">
                     <a href="http://localhost/newbus/tickets/print?pnr=<?php echo $pnr;?>" > <button class="btn btn-danger">Print Ticket</button></a>
                    </div>
                   
                </div>
               
            </div>
            <div  style="height:1rem"></div>

            <?php }?>
        </div>
    </div>
</div>