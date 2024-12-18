<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['uid'])) {
  header("Location: ./signin.php");
}
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
} ?>
<?php require './header.php'?>
<div class="container my-5" style="padding-top: 200px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Profile Card -->
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <img src="../Assets/img/avt.jpg" alt="User Avatar" class="rounded-circle mb-3" style="width: 100px;">
                    <?php
                        $conn = OpenCon();
                        $query = "SELECT * FROM user_info WHERE user_id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $_SESSION['uid']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $user = $result->fetch_assoc();
                    ?>
                    <h4 class="text-accent mb-2"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h4>
                    <p class="text-neutral-3 mb-3"><?= htmlspecialchars($user['email']) ?></p>
                    <button class="btn btn-primary" id="changePasswordBtn">Đổi mật khẩu</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 justify-content-center" id="changePasswordForm" style="display: none;">
        <div class="col-md-6 mx-auto">
            <!-- Change Password Form -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="text-secondary mb-4">Đổi mật khẩu</h5>
                    <form method="post" action="change_password.php">
                        <div class="mb-3">
                            <label for="oldPassword" class="form-label text-neutral-2">Mật khẩu cũ</label>
                            <input type="password" class="form-control" id="oldPassword" name="old_password" placeholder="Mật khẩu cũ" required>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label text-neutral-2">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="newPassword" name="new_password" placeholder="Mật khẩu mới" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label text-neutral-2">Nhập lại mật khẩu</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-neutral me-2" id="cancelBtn">Cancel</button>
                            <?php 
                            echo '
                                <button type="button" class="btn btn-success" id="saveBtn" token="' . htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES) . '">Save</button>
                            '
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require './footer.html'?>

<script src="./js/action.js"></script>
<script>
    document.getElementById('changePasswordBtn').addEventListener('click', function() {
        document.getElementById('changePasswordForm').style.display = 'block';
    });

    document.getElementById('cancelBtn').addEventListener('click', function() {
        document.getElementById('changePasswordForm').style.display = 'none';
    });
    
    document.getElementById('saveBtn').addEventListener('click', function() {
        const oldPassword = document.getElementById('oldPassword').value;
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        if (newPassword!== confirmPassword) {
            alert('Mật khẩu mới và nhập lại mật khẩu phải giống nhau');
            return;
        }
        const csrfToken = document.getElementById('saveBtn').getAttribute('token');
        if (confirm("Bạn chắc chắn muốn đổi mật khẩu?")) {
            changePassword(oldPassword, newPassword, csrfToken);
            // console.log(oldPassword)
            // console.log(newPassword)
            // console.log(confirmPassword)
            // console.log(csrfToken)
        };
    });
</script>
