<?php require './header.php'?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Profile Card -->
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <img src="https://via.placeholder.com/100" alt="User Avatar" class="rounded-circle mb-3">
                    <h4 class="text-accent mb-2">John Doe</h4>
                    <p class="text-neutral-3 mb-3">johndoe@example.com</p>
                    <button class="btn btn-primary">Edit Profile</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 justify-content-center">
        <div class="col-md-8">
            <!-- User Info Form -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="text-secondary mb-4">User Information</h5>
                    <form>
                        <div class="mb-3">
                            <label for="fullName" class="form-label text-neutral-2">Full Name</label>
                            <input type="text" class="form-control" id="fullName" placeholder="Enter your full name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label text-neutral-2">Email Address</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label text-neutral-2">Phone Number</label>
                            <input type="text" class="form-control" id="phone" placeholder="Enter your phone number">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-neutral me-2">Reset</button>
                            <button type="submit" class="btn btn-accent">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require './footer.html'?>

