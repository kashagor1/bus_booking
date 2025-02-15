
  <div class="container">
    <h1 class="mt-5">Payment Details</h1>
    <form action="process_payment" method="POST">
      <div class="mb-3">
        <label for="card_number" class="form-label">Card Number:</label>
        <input type="text" class="form-control" id="card_number" value="4032033933886793" name="card_number" placeholder="Card number" required>
      </div>

      <div class="mb-3">
        <label for="card_holder" class="form-label">Card Holder:</label>
        <input type="text" class="form-control" id="card_holder" value="John Doe" name="card_holder" placeholder="Card holder's name" required>
      </div>

      <div class="mb-3">
        <label for="expiry_date" class="form-label">Expiry Date:</label>
        <input type="text" class="form-control" id="expiry_date" value="12/28" name="expiry_date" placeholder="MM/YY" required>
      </div>

      <div class="mb-3">
        <label for="cvv" class="form-label">CVV:</label>
        <input type="text" class="form-control" id="cvv" name="cvv" placeholder="CVV" value="159" required>
      </div>

      <button type="submit" class="btn btn-primary">Make Payment</button>
    </form>
  </div>
