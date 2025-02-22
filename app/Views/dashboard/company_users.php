<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">

                <form class="row g-3" method="POST">

                    <div class="col-4">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control " name="username" id="username">
                    </div>
                    <div class="col-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control " name="registerPassword" id="password">
                    </div>
                    <div class="col-4">
                        <label for="role_type" class="form-label">Role Type</label>

                        <select name="role_type" id="role_type" class="form-control">
                            <option value="100">Company Agent</option>                            
                            <option value="110">Company Admin</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="fullName" id="fullname">
                    </div>
                    <div class="col-4">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="number" class="form-control" name="phone" id="phone">
                    </div>
                    <div class="col-4">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control"  name="email" id="email">
                    </div>
                    <div class="col-12 py-3">
                        <button type="submit" class="btn btn-primary">ADD USER</button>
                    </div>
                </form>
            </div>
            <div class="col-2"></div>


        </div>
    </div>
</section>
