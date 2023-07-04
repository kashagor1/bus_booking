<div class="container">
    <h2 class="text-center mb-4">Login or Register</h2>
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="mb-3">
          <p class="text-center text-danger">Oops! It seems you are not a user. Please Login or Register.</p>
        </div>
        <div class="mb-3">
          <ul class="nav nav-pills justify-content-center">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#loginForm" data-bs-toggle="tab">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#registerForm" data-bs-toggle="tab">Register</a>
            </li>
          </ul>
        </div>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="loginForm">
            <form class="needs-validation" action="login" method="post" novalidate>
              <div class="mb-3">
                <label for="loginUsername" class="form-label">Username</label>
                <input type="text" class="form-control" id="loginUsername" name="loginUsername" required>
              </div>
              <div class="mb-3">
                <label for="loginPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="loginPassword" name="loginPassword" required>
              </div>
              <button type="submit" class="btn btn-primary">Login</button>
            </form>
          </div>
          <div class="tab-pane fade" id="registerForm">
            <form class="needs-validation" action="newreg" method="post" novalidate>
              <div class="mb-3">
                <label for="fullName" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="fullName" name="fullName" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
              </div>
              <div class="mb-3">
                <label for="registerPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="registerPassword" name="registerPassword" required>
              </div>
              <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                <div id="passwordError" class="invalid-feedback">Passwords do not match.</div>

              </div>
              <button type="submit" class="btn btn-primary">Register</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>