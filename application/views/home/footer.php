<footer class="footer mt-auto py-3 bg-body-tertiary">
  <div class="container">
    <span class="text-body-secondary">© 2023 | All Rights Resevered by ka.shagor</span>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
  flatpickr('#date-input', {
    // Options and customization can be added here
  });
});


        // Sample JSON data for search results
        function setupLiveSearch(inputId, resultsId) {
  var inputField = document.getElementById(inputId); 
  var searchResults = document.getElementById(resultsId);

  inputField.addEventListener("input", function() {
    var searchTerm = inputField.value.toLowerCase();
    console.log(searchTerm);

    // Clear the search results if the search term is empty
    if (searchTerm.length <= 2) {
      searchResults.innerHTML = "";
      return;
    }

    // Make an asynchronous request to fetch search results from the server
    fetch('http://localhost/newbus/district')
      .then(response => response.json())
      .then(data => {
        searchResults.innerHTML = "";

        data.forEach(function(result) {
          var resultName = result.district_name.toLowerCase();

          if (resultName.includes(searchTerm)) {
            var resultItem = document.createElement("div");
            resultItem.textContent = result.district_name;
            resultItem.addEventListener("click", function() {
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



        // Get the current date
        var currentDate = new Date();

        // Calculate the date for 7 days from now
        var next7Days = new Date();
        next7Days.setDate(currentDate.getDate() + 7);

        // Format the dates in YYYY-MM-DD format
        var currentDateFormatted = currentDate.toISOString().split('T')[0];
        var next7DaysFormatted = next7Days.toISOString().split('T')[0];

        // Set the minimum and maximum date values for the date input
        document.getElementById("date-input").setAttribute("min", currentDateFormatted);
        document.getElementById("date-input").setAttribute("max", next7DaysFormatted);

    </script>

</body>
</html>