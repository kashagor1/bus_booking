<div class="container tcontainer">
    <div class="row p-2">
        <h4 class="text-center">Purchased Tickets</h4>
    </div>
    <div class="row">
        <div class="col-12 py-3">
            <table id="ticketsTable" class="display">
                <thead>
                    <tr>
                        <th>Boarding - Destination</th>
                        <th>Purchase Date</th>
                        <th>Journey Date</th>
                        <th>Seats</th>
                        <th>Fare</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $ticket): ?>
                        <tr>
                            <td><?php echo $ticket['boarding'] . " - " . $ticket['destination']; ?></td>
                            <td><?php echo $ticket['b_date']; ?></td>
                            <td><?php echo $ticket['j_date']; ?></td>
                            <td><?php echo rtrim($ticket['seats'], ','); ?></td>
                            <td><?php echo $ticket['fare'] * count(explode(',', rtrim($ticket['seats'], ','))); ?></td>
                            <td>
                                <a href="<?= base_url() ?>personal/tickets/print?pnr=<?php echo $ticket['pnr']; ?>" class="btn btn-primary">Print</a>
                                <?php
                                $currentDate = date('Y-m-d');
                                $dateDiff = floor((strtotime($ticket['j_date']) - strtotime($currentDate)) / (60 * 60 * 24));
                                $showCancelTicketButton = ($dateDiff >= 2); // Or TRUE, as before
                                if ($showCancelTicketButton): ?>
                                    <a href="<?= base_url() ?>personal/tickets/cancel_ticket?pnr=<?php echo $ticket['pnr']; ?>" class="btn btn-danger">Cancel</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#ticketsTable').DataTable(); // Initialize DataTable
    });
</script>