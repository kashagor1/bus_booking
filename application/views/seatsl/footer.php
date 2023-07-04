</main>


<script>
var passwordInput = document.getElementById('registerPassword');
var confirmPasswordInput = document.getElementById('confirmPassword');
var passwordError = document.getElementById('passwordError');

passwordInput.addEventListener('input', validatePasswords);
confirmPasswordInput.addEventListener('input', validatePasswords);

function validatePasswords() {
  var password = passwordInput.value;
  var confirmPassword = confirmPasswordInput.value;

  if (password !== confirmPassword) {
    passwordError.style.display = 'block';
  } else {
    passwordError.style.display = 'none';
  }
}
</script>

<script>



  function showLoginForm() {
  document.getElementById("loginForm").style.display = "block";
  document.getElementById("registerForm").style.display = "none";
}

function showRegisterForm() {
  document.getElementById("loginForm").style.display = "none";
  document.getElementById("registerForm").style.display = "block";
}

function handleSeatSelection() {
  var selectedSeats = [];
  var maxSelection = 4;

  var seats = document.querySelectorAll(".seat");
  seats.forEach(function (seat) {
    seat.addEventListener("click", function () {
      this.classList.toggle("selected");
      var seatId = this.id;
      var seatPrice = this.dataset.fare;

      if (selectedSeats.includes(seatId)) {
        selectedSeats = selectedSeats.filter(function (selectedSeat) {
          return selectedSeat !== seatId;
        });
      } else {
        if (selectedSeats.length < maxSelection) {
          selectedSeats.push(seatId);
        } else {
          alert("You can only select a maximum of " + maxSelection + " seats.");
          this.classList.remove("selected");
        }
      }

      updateSelectedSeats();
    });
  });

  function updateSelectedSeats() {
    var form = document.getElementById("selectionForm");
    var seatsInput = form.querySelector('input[name="seats"]');

    if (!seatsInput) {
      seatsInput = document.createElement("input");
      seatsInput.type = "hidden";
      seatsInput.name = "seats";
      form.appendChild(seatsInput);
    }

    seatsInput.value = selectedSeats.join(",");

    showPrice();
  }

  function showPrice() {
    var selectedSeatsList = document.getElementById("selectedSeatsList");
    selectedSeatsList.innerHTML = "";

    selectedSeats.forEach(function (selectedSeat) {
      var seatButton = document.getElementById(selectedSeat);
      var seatPrice = seatButton.dataset.fare;

      var li = document.createElement("li");
      li.textContent = selectedSeat + " - Price: " + seatPrice;
      selectedSeatsList.appendChild(li);
    });
  }

  // Call the seat selection function
  updateSelectedSeats();
}

// Call the seat selection function
handleSeatSelection();




// function handleSeatSelection() {
//   var selectedSeats = [];
//   var maxSelection = 4;

//   var seats = document.querySelectorAll(".seat");
//   seats.forEach(function (seat) {
//     seat.addEventListener("click", function () {
//       this.classList.toggle("selected");
//       var seatId = this.id;
//       var seatPrice = this.dataset.fare;

//       if (selectedSeats.includes(seatId)) {
//         selectedSeats = selectedSeats.filter(function (selectedSeat) {
//           return selectedSeat !== seatId;
//         });
//       } else {
//         if (selectedSeats.length < maxSelection) {
//           selectedSeats.push(seatId);
//         } else {
//           alert("You can only select a maximum of " + maxSelection + " seats.");
//           this.classList.remove("selected");
//         }
//       }

//       updateSelectedSeats();
//     });
//   });

//   function updateSelectedSeats() {
//     var selectedSeatsList = document.getElementById("selectedSeatsList");
//     var totalPrice = 0;

//     selectedSeatsList.innerHTML = "";

//     selectedSeats.forEach(function (selectedSeat) {
//       var seatButton = document.getElementById(selectedSeat);
//       var seatPrice = seatButton.dataset.fare;

//       var li = document.createElement("li");
//       li.textContent = selectedSeat + " - Price: " + seatPrice;
//       selectedSeatsList.appendChild(li);

//       totalPrice += parseInt(seatPrice);
//     });

//     var total = document.createElement("li");
//     total.textContent = "Total Price: " + totalPrice;
//     selectedSeatsList.appendChild(total);

//     var form = document.getElementById("checkoutForm");
//     var seatsInput = form.querySelector('input[name="seats"]');

//     if (!seatsInput) {
//       seatsInput = document.createElement("input");
//       seatsInput.type = "hidden";
//       seatsInput.name = "seats";
//       form.appendChild(seatsInput);
//     }

//     seatsInput.value = selectedSeats.join(",");
//   }

//   // Call the seat selection function
//   updateSelectedSeats();
// }

// // Call the seat selection function
// handleSeatSelection();




   
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 
  </body>
  </html>