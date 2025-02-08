<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Ticket Booking</title>
    <!-- Load CSS files -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">
    <style>
        /* Your CSS styles here */
        .seat-map {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(30px, 1fr));
            gap: 5px;
            margin-top: 20px;
        }
        .seat {
            width: 30px;
            height: 30px;
            background-color: #eee;
            border: 1px solid #ccc;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
        .seat.available { background-color: green; }
        .seat.unavailable { background-color: red; }
        .seat.selected { background-color: orange; }
        .seat-number { display: none; }
        .seat:hover .seat-number { display: block; }
        #selected-seats { margin-top: 20px; }
        .custom-input {
            border: 1px solid #ced4da;
            border-radius: .25rem;
            padding: .375rem .75rem;
        }
        .form_header {
            font-size: small;
            color: #757A7E;
        }
        .sicon {
            font-size: large;
            color: #757A7E;
        }
        .b_submit_button {
            background-color: #FFC107;
            border: none;
            color: white;
        }
        .card {
            border: none;
            box-shadow: 2px 2px 5px lightgray;
        }
        .modal-body {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
            <div class="card-body">
                <form action="<?= site_url('search') ?>" method="get">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="origin-input" class="form_header"><i class="sicon fa-solid fa-bus-simple"></i> Origin</label>
                            <input type="text" class="custom-input" name="origin" value="<?= !empty($_GET['origin']) ? esc($_GET['origin']) : '' ?>" id="origin-input" required>
                        </div>
                        <div class="col-md-3">
                            <label for="destination-input" class="form_header"><i class="sicon fa-solid fa-bus-simple"></i> Destination</label>
                            <input type="text" class="custom-input" name="destination" value="<?= !empty($_GET['destination']) ? esc($_GET['destination']) : '' ?>" id="destination-input" required>
                        </div>
                        <div class="col-md-3">
                            <label for="date-input" class="form_header"><i class="sicon fa-solid fa-calendar-days"></i> Date</label>
                            <input type="date" class="custom-input" name="date" value="<?= !empty($_GET['date']) ? esc($_GET['date']) : '' ?>" id="date-input" required>
                        </div>
                        <div class="col-md-3 d-grid gap-2">
                            <button class="btn btn-warning p-3 b_submit_button" type="submit">Search Bus</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="position-sticky" style="top: 2rem;">
                    <div class="p-4 mb-3 bg-body-tertiary rounded">
                        <div class="companyType">
                            <h4>Bus Companies</h4>
                            <label><input type="checkbox" class="companyFilter" value="Ena"> Ena</label>
                            <label><input type="checkbox" class="companyFilter" value="Hanif"> Hanif</label>
                        </div>
                        <div id="busTypeFilter">
                            <h4>Bus Type</h4>
                            <label><input type="checkbox" class="busType" value="AC Premium"> AC</label>
                            <label><input type="checkbox" class="busType" value="NON_AC"> NON_AC</label>
                            <label><input type="checkbox" class="busType" value="Classic"> Classic</label>
                        </div>
                        <div class="priceFilter">
                            <h4>Price Range</h4>
                            <label for="minPrice">Min Price:</label>
                            <input type="number" id="minPrice" min="0" class="custom-input">
                            <label for="maxPrice">Max Price:</label>
                            <input type="number" id="maxPrice" min="0" class="custom-input">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <table class="table table-striped" id="busTable">
                    <thead>
                        <tr>
                            <th class="header">Operator (Bus Type)</th>
                            <th class="header">Dep. Time</th>
                            <th class="header">Arr. Time</th>
                            <th class="header">Seats Available</th>
                            <th class="header">Fare</th>
                            <th class="header">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($result)): ?>
                            <?php foreach ($result as $trip): ?>
                                <tr class="trip-row">
                                    <td>
                                        <?= esc($trip['company_name']) ?> (<?= esc($trip['coach_type']) ?>)<br>
                                        Route: <?= esc(implode(" - ", array_column($trip['or_route'], 'route_name'))) ?><br>
                                        Starting Point: <?= esc($trip['main_boarding']) ?><br>
                                        Ending Point: <?= esc($trip['final_destination']) ?>
                                    </td>
                                    <td><?= date('h:i A', strtotime(esc($trip['departure']))) ?></td>
                                    <td><?= date('h:i A', strtotime(esc($trip['arrival']))) ?></td>
                                    <td><?= esc($trip['seat_layout'] - $trip['av_seats']) ?></td>
                                    <td><?= esc($trip['final_fare']) ?></td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm btnSubmit seatsLayout" 
                                            data-bs-toggle="modal" data-bs-target="#seatModal"
                                            data-params='<?= json_encode([
                                                "origin" => base64_encode($_GET['origin']),
                                                "destination" => base64_encode($_GET['destination']),
                                                "coach_id" => $trip['coach_id'],
                                                "route_id" => $trip['route_id'],
                                                "fare" => $trip['final_fare'],
                                                "date" => $_GET['date'],
                                                "trip_id" => $trip['trip_id']
                                            ]) ?>'>
                                            View Seats
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6">No trips found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Seat Selection Modal -->
    <div class="modal fade" id="seatModal" tabindex="-1" aria-labelledby="seatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="seatModalLabel">Seat Selection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="seat-map-container"></div>
                    <div id="selected-seats">Selected Seats: </div>
                    <div id="total-fare">Total Fare: </div>
                    <button id="book-now" class="btn btn-primary">Book Now</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Load JS files -->
    <script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script>
        $(document).ready(function() {
            let selectedSeats = [];
            let totalFare = 0;

            $('.seatsLayout').click(function() {
                const params = $(this).data('params');
                const modalBody = $('#seatModal .modal-body');
                const seatMapContainer = $('#seat-map-container');
                const selectedSeatsDisplay = $('#selected-seats');
                const totalFareDisplay = $('#total-fare');
                const bookNowButton = $('#book-now');

                seatMapContainer.empty();
                selectedSeats = [];
                totalFare = 0;

                $.ajax({
                    url: '<?= site_url('get_seat_map') ?>',
                    type: 'POST',
                    data: params,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const seatMap = response.seat_map;

                            let seatMapHtml = '<div class="seat-map">';
                            seatMap.forEach(row => {
                                seatMapHtml += '<div class="row">';
                                row.forEach(seat => {
                                    const seatClass = seat.available ? 'seat available' : 'seat unavailable';
                                    seatMapHtml += `
                                        <div class="${seatClass}" data-seat-number="${seat.seat_number}" data-fare="${params.fare}">
                                            <span class="seat-number">${seat.seat_number}</span>
                                        </div>`;
                                });
                                seatMapHtml += '</div>';
                            });
                            seatMapHtml += '</div>';

                            seatMapContainer.html(seatMapHtml);
                            modalBody.append(seatMapContainer);

                            $('.seat').click(function() {
                                if ($(this).hasClass('available')) {
                                    $(this).toggleClass('selected');
                                    updateSelectedSeats();
                                }
                            });

                            updateSelectedSeats();

                             bookNowButton.click(function() {
        $.ajax({
            url: '<?= site_url('book_seats') ?>',
            type: 'POST',
            data: {
                ...params,
                selected_seats: selectedSeats
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Redirect to booking page with booking ID or other relevant data
                    const bookingId = response.booking_id; // Assuming your server returns a booking ID
                    window.location.href = `<?= site_url('booking_page') ?>?booking_id=${bookingId}`; // Construct URL with booking ID

                    // Or, if you don't have a booking ID but just want to redirect:
                    // window.location.href = '<?= site_url('booking_page') ?>';

                } else {
                    alert("Booking Failed: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                alert("An error occurred. Please try again.");
            }
        });
    });

                        } else {
                            console.error('Error fetching seat map:', response.message);
                            alert("Error fetching seat map: " + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        alert("An error occurred. Please try again.");
                    }
                });

                function updateSelectedSeats() {
                    selectedSeats = [];
                    totalFare = 0;
                    const selectedSeatElements = $('.seat.selected');

                    selectedSeatElements.each(function() {
                        const seatNumber = $(this).data('seat-number');
                        const fare = $(this).data('fare');
                        selectedSeats.push(seatNumber);
                        totalFare += fare;
                    });

                    selectedSeatsDisplay.text("Selected Seats: " + selectedSeats.join(', '));
                    totalFareDisplay.text("Total Fare: ৳" + totalFare);
                }
            });
        });
    </script>
</body>
</html>