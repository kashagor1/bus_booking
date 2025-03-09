<div class="bg-light d-flex justify-content-center align-items-center py-4">

    <div class="card shadow-lg p-4" style="width: 400px;">
        <h3 class="text-center">Register</h3>
        <form class="needs-validation" action="register" method="post" novalidate>
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="fullName" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="fullName" name="fullName" required>
                <div class="invalid-feedback">Full Name is required.</div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <div class="invalid-feedback">Valid email is required.</div>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
                <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                <div class="invalid-feedback">Phone number is required.</div>
            </div>
            <div class="mb-3">
                <label for="registerPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="registerPassword" name="registerPassword" required>
                <div class="invalid-feedback">Password is required.</div>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                <div id="passwordError" class="invalid-feedback">Passwords do not match.</div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
        <p class="text-center mt-3">Already have an account? <a href="<?= base_url('login') ?>">Login here</a></p>
    </div>
    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute("6LcZDugqAAAAALqI99uP9QpqwP4dQ3GqJkxmO49V", { action: "newreg" }).then(function (token) {
                document.getElementById("g-recaptcha-response").value = token;
            });
        });
    </script>
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

                // Confirm Password Validation
                const registerPassword = document.getElementById("registerPassword");
                const confirmPassword = document.getElementById("confirmPassword");
                const passwordError = document.getElementById("passwordError");

                confirmPassword.addEventListener("input", function () {
                    if (registerPassword.value !== confirmPassword.value) {
                        confirmPassword.classList.add("is-invalid");
                        passwordError.style.display = "block";
                    } else {
                        confirmPassword.classList.remove("is-invalid");
                        passwordError.style.display = "none";
                    }
                });
            });
        })();
    </script>

</div>