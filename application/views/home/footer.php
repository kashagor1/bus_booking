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
      fetch('http://newbus.kashagor.onlinedistrict')
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