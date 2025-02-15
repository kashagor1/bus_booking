</main>

<footer class="footer mt-auto py-3 bg-body-tertiary">
  <div class="container">
    <span class="text-body-secondary">© 2023 | All Rights Resevered by ka.shagor</span>
  </div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="<?PHP ECHO BASE_URL();?>ASSETS/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?PHP ECHO BASE_URL();?>ASSETS/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?PHP ECHO BASE_URL();?>ASSETS/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?PHP ECHO BASE_URL();?>ASSETS/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?PHP ECHO BASE_URL();?>ASSETS/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?PHP ECHO BASE_URL();?>ASSETS/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

<script src="<?PHP ECHO BASE_URL();?>ASSETS/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?PHP ECHO BASE_URL();?>ASSETS/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?PHP ECHO BASE_URL();?>ASSETS/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <script>
 $(document).ready(function () {
    $('#rlist').DataTable({
        "columns": [
            { "searchable": false },
            { "searchable": true },
            { "searchable": false },
            { "searchable": false },
            { "searchable": false },
            { "searchable": false }
        ],
        "language": {
            "search": "Search By PNR :"
        }
    });
});

</script>

<script>
$(document).ready(function() {
    $('.viewseats').on('click', function() {
        try {
            const params = JSON.parse(this.dataset.params);
            const filteredParams = {
                trip_id: params.trip_id,
                route_id: params.route_id,
                coach_id: params.coach_id
            };
            console.log(params);
            const canme  = $('#exampleModalLabel').text(params.company_name);
            const routeInfo  = $('<span class="text-sm" style="font-size:13px;padding:0 10px">').text('('+atob(params.origin) + ' to ' + atob(params.destination)+')');
            const routeInfo2  = $('<span class="text-sm" style="font-size:12px;padding:0 20px">').text(' Journey Date & Time: '+params.date+' ('+params.departure + ' to ' + params.arrival+')');
            canme.append(routeInfo,routeInfo2);


            $.post("seatselection", filteredParams, function(responseData) { // Directly use $.post
                if (responseData.status) {
                    const data = responseData.data;  // Access the 'data' part of the response

                    // Update the modal body with the received data
                    updateModalBody(data, params); // Pass the data and params to the function

                    // Show the modal (if not already shown) - Make sure you have the correct modal ID
                    $('#exampleModal').modal('show'); // Replace #exampleModal if needed

                } else {
                    console.error("API Error:", responseData.message);
                    // Handle error, e.g., display a message to the user
                    alert("Error fetching seat information: " + responseData.message); // Example alert
                }
            }, "json").fail(function(error) {
                console.error("AJAX Error:", error);
                alert("An error occurred while making the request."); // Example alert
            });


        } catch (error) {
            console.error("Error:", error);
            alert("An error occurred: " + error); // Example alert
        }
    });

function updateModalBody(data,params) {
    const $modalBody = $('#exampleModal .modal-body'); // Select the modal body within the modal
    console.log(params);
    // Clear previous content
    const p_fare = params.fare;
    $modalBody.empty();

    // Build the seat selection table
    const $seatTable = $('<table><tbody></tbody></table>');
    const row = data.info.seat_row;
    const col = data.info.seat_column;
    let sts = 1;
    const bookedSeats = data.results.map(seat => seat.seat_no); // Extract booked seat numbers
    const selectedSeats = []; // Keep track of selected seats

    for (let i = 1; i <= row; i++) {
        const $row = $('<tr></tr>');
        const seatLetter = String.fromCharCode(i + 64);
        for (let j = 1; j <= col; j++) {
            const seatNo = seatLetter + j;
            const isSeatAvailable = !bookedSeats.includes(seatNo) && !selectedSeats.includes(seatNo);
            const seatClass = isSeatAvailable ? "available" : "unavailable";
            const disabledAttr = isSeatAvailable ? "" : "disabled";
            const $seatButton = $(`<button id='${seatNo}' class='seat ${seatClass}' coachinfo='${data.info.coach_id}' data-fare='${data.fare}' ${disabledAttr}>${seatNo}</button>`);

            $seatButton.click(function() { // Seat click handler
                if ($(this).hasClass('available')) {
                    if (selectedSeats.length >= 4 && !$(this).hasClass('selected')) { // Check before toggling
                        alert("You can't select more than 4 seats!");
                        return;
                    }
                    $(this).toggleClass('selected');
                    if ($(this).hasClass('selected')) {
                        selectedSeats.push(seatNo);
                    } else {
                      selectedSeats.splice(selectedSeats.indexOf(seatNo), 1); // Remove from selected

                    }
                    updateSelectedSeatsList(selectedSeats,p_fare);
                }
            });

            $row.append($('<td>').append($seatButton));
            if (j === 2) {
                $row.append('<td></td>'); // Add empty cell
            }
            sts++;
        }
        $seatTable.append($row);
    }

    // Create row container
    const $rowContainer = $('<div class="row"></div>');

    // Seat selection column
    const $seatSelectionDiv = $('<div class="col-8"></div>').append(
        $('<div class="seat-selection"><div class="seats-container"></div></div>').append($seatTable)
    );

    // Form column
    const $formDiv = $('<div class="col-4"></div>');
    const $selectedSeatsDiv = $('<div><h4>Selected Seats:</h4><form id="selectionForm" method="POST" action="midform"></form></div>');
    const $selectedSeatsList = $('<ul id="selectedSeatsList"></ul>');
    const $form = $selectedSeatsDiv.find('form');
    const $totalDiv = $('<hr><h4>Total: <span id="totalAmount">0</span></h4>');


    
    $form.append($selectedSeatsList);

    // Add hidden input fields to the form
    $form.append(`<input type="hidden" name="coach_id" value="${data.info.coach_id}">`);
    $form.append(`<input type="hidden" name="fare" value="${params.fare}">`);
    $form.append(`<input type="hidden" name="trip_id" value="${params.trip_id}">`);
    $form.append(`<input type="hidden" name="route_id" value="${params.route_id}">`);
    $form.append(`<input type="hidden" name="origin" value="${params.origin}">`);
    $form.append(`<input type="hidden" name="destination" value="${params.destination}">`);
    $form.append(`<input type="hidden" name="date" value="${params.date}">`);
    $form.append($totalDiv);


    $form.append('<button type="submit" id="checkoutBtn" disabled>Checkout</button>'); // Disable initially
    $form.submit(function(event) {  // Form submit handler
            const selectedSeatsJson = JSON.stringify(selectedSeats); // Convert to JSON string
            $form.append(`<input type="hidden" name="selected_seats" value='${selectedSeatsJson}'>`);
        });
    $formDiv.append($selectedSeatsDiv);

    // Append both sections to row container
    $rowContainer.append($seatSelectionDiv, $formDiv);

    // Append row container to modal body
    $modalBody.append($rowContainer);

    updateSelectedSeatsList(selectedSeats,p_fare); // Initial update of selected seats list
}

 function updateSelectedSeatsList(selectedSeats, p_fare) {
    const $selectedSeatsList = $('#selectedSeatsList');
    const $totalAmount = $('#totalAmount');
    const $checkoutBtn = $('#checkoutBtn'); // Get the checkout button
    $selectedSeatsList.empty();

    let total = 0; // Calculate total more efficiently
    selectedSeats.forEach(seat => {
        $selectedSeatsList.append(`<li>${seat} - ${p_fare}</li>`);
    });

    $totalAmount.text(selectedSeats.length*p_fare);

    // Enable/disable checkout button based on seat selection
    $checkoutBtn.prop('disabled', selectedSeats.length === 0);
}

});
</script>





<script>
  // JavaScript code to handle button click event
 // JavaScript code to handle button click event
var buttons = document.querySelectorAll(".btnSubmit");
buttons.forEach(function(button) {
  button.addEventListener("click", function(event) {
    // Retrieve the data from data attributes
    var params = this.dataset.params;

    // Create a hidden input field to store the parameters
    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "params";
    input.value = params;

    // Create a form and append the input field
    var form = document.createElement("form");
    form.method = "post";
    form.action = "seatselection";
    form.appendChild(input);

    // Append the form to the document body
    document.body.appendChild(form);

    // Submit the form
    form.submit();
  });
});

</script>

<script>




  
//  $(document).ready(function() {
//       // Initialize DataTable
//       var table = $('#busTable').DataTable({
//         "lengthMenu": [ -1 ],
//         "paging": false,
//         "searching": true,
//         "language": {
//             "emptyTable": "Opps! Sorry No Bus Is Available!"
//         }
//       });
//       $("#busTable_filter").hide();


//       // Handle company filter
//       $('.companyFilter').on('change', function() {
//         var selectedCompanies = [];
//         $('.companyFilter:checked').each(function() {
//           selectedCompanies.push($(this).val());
//         });
//         table.columns(0).search(selectedCompanies.join('|'), true, false).draw();
//       });

//       // Handle bus type filter
//       $('.busType').on('change', function() {
//         var selectedBusTypes = [];
//         $('.busType:checked').each(function() {
//           selectedBusTypes.push($(this).val());
//         });
//         table.columns(1).search(selectedBusTypes.join('|'), true, false).draw();
//       });

//       // Handle price range filter
//       $('#minPrice, #maxPrice').on('keyup', function() {
//         var minPrice = $('#minPrice').val();
//         var maxPrice = $('#maxPrice').val();
//         table.columns(2).search(minPrice + '-' + maxPrice, true, false).draw();
//       });
//     });
$(document).ready(function() {
    var table = $('#busTable').DataTable({
        "lengthMenu": [ -1 ],
        "order": [[1, "desc"]],
        "paging": false,
        "searching": true,
        "language": {
            "emptyTable": "Oops! Sorry, No Bus Is Available!"
        }
    });
    $("#busTable_filter").hide();

    // Handle company filter
    $('.companyFilter').on('change', function() {
        var selectedCompanies = [];
        $('.companyFilter:checked').each(function() {
            selectedCompanies.push($(this).val());
        });
        table.columns(0).search(selectedCompanies.join('|'), true, false).draw();
    });

    // Handle bus type filter
    $('.busType').on('change', function() {
        var selectedBusTypes = [];
        $('.busType:checked').each(function() {
            selectedBusTypes.push($(this).val());
        });
        table.columns(0).search(selectedBusTypes.join('|'), true, false).draw();
    });

    // Handle price range filter
    $('#minPrice, #maxPrice').on('keyup', function() {
    var minPrice = parseFloat($('#minPrice').val());
    var maxPrice = parseFloat($('#maxPrice').val());
    table.column(4).search(function(data, _, rowData) {
        var fare = parseFloat(data.replace(/[^\d.]/g, ''));
        return fare >= minPrice && fare <= maxPrice;
    }).draw();
});


});

</script>
<script>
 

  // Sample JSON data for search results
  function setupLiveSearch(inputId, resultsId) {
    var inputField = document.getElementById(inputId);
    var searchResults = document.getElementById(resultsId);

    inputField.addEventListener("input", function () {
      var searchTerm = inputField.value.toLowerCase();
      console.log(searchTerm);

      // Clear the search results if the search term is empty
      if (searchTerm.length <= 2) {
        searchResults.innerHTML = "";
        return;
      }

      // Make an asynchronous request to fetch search results from the server
      fetch('<?=BASE_URL()?>district')
        .then(response => response.json())
        .then(data => {
          searchResults.innerHTML = "";

          data.forEach(function (result) {
            var resultName = result.district_name.toLowerCase();

            if (resultName.includes(searchTerm)) {
              var resultItem = document.createElement("div");
              resultItem.textContent = result.district_name;
              resultItem.addEventListener("click", function () {
                inputField.value = result.district_name;
                searchResults.innerHTML = "";
              });
              searchResults.appendChild(resultItem);
            }
          });
        })
        .catch(error => {
          console.error('Error:', error);
        });
    });
  }

  // Setup live search for origin input
  setupLiveSearch("origin-input", "origin-search-results");

  // Setup live search for destination input
  setupLiveSearch("destination-input", "destination-search-results");


</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- <script>
    flatpickr("#date-input", {
      minDate: null,
      maxDate: new Date().fp_incr(7),
      disable: [
        function(date) {
          // Disable dates in the past
          return date < new Date();
        },
        function(date) {
          // Disable dates more than 7 days in the future
          return date > new Date().fp_incr(7);
        }
      ]
    });
</script> -->
<script>
  // Get the current date in GMT+6
  var currentDate = new Date(); // Get the current date
  // currentDate.setHours(currentDate.getHours() - 6); // Adjust for GMT+6
  // console.log(currentDate);

  flatpickr("#date-input", {
    minDate: currentDate,
    maxDate: currentDate.fp_incr(7),
    disable: [
      function(date) {
        // Disable dates more than 7 days in the future
        return date > currentDate.fp_incr(7);
      }
    ]
  });
</script>


</body>

</html>