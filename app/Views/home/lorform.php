<div class="bg-light d-flex justify-content-center align-items-center vh-100">

  <div class="card shadow-lg p-4" style="width: 400px;">
    <h3 class="text-center">Login</h3>
    <form class="needs-validation" action="login" method="post" novalidate>
      <?= csrf_field() ?>
      <div class="mb-3">
        <label for="loginUsername" class="form-label">Username</label>
        <input type="text" class="form-control" id="loginUsername" name="loginUsername" required>
        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
        <div class="invalid-feedback">Username is required.</div>
      </div>
      <div class="mb-3">
        <label for="loginPassword" class="form-label">Password</label>
        <input type="password" class="form-control" id="loginPassword" name="loginPassword" required>
        <div class="invalid-feedback">Password is required.</div>
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <p class="text-center mt-3">Don't have an account? <a href="<?= base_url('register') ?>">Register here</a></p>
  </div>

  <script>
    (function () {
      'use strict';
      document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector('.needs-validation');
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        });
      });
    })();
  </script>

</div>


<script>
  grecaptcha.ready(function () {
    grecaptcha.execute("6LcZDugqAAAAALqI99uP9QpqwP4dQ3GqJkxmO49V", { action: "newreg" }).then(function (token) {
      document.getElementById("g-recaptcha-response").value = token;
    });
  });
</script>