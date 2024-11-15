<?php require_once("./server/server.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="./css/material-design-iconic-font.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

    <div class="main" style="padding-top: 90px;">

        <!-- Sign In Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure>
                            <img src="./images/signup-image.jpg" alt="Sign up image">
                        </figure>
                        <a href="../index.php" class="signup-image-link">Back To Home</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">ADMIN LOGIN</h2>
                        <form class="register-form" id="login-form" action="login.php" method="post">
                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger">
                                    <h4 id="e_msg">
                                        <?php foreach ($errors as $error): ?>
                                            <?= htmlspecialchars($error) ?><br>
                                        <?php endforeach; ?>
                                    </h4>
                                </div>
                            <?php endif; ?>

                            <div class="form-group">
                                <label for="admin_username">
                                    <i class="zmdi zmdi-account material-icons-name"></i>
                                </label>
                                <input 
                                    type="text" 
                                    name="admin_username" 
                                    id="admin_username" 
                                    placeholder="Admin Email" 
                                    required 
                                    pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" 
                                    title="Please enter a valid email address"
                                >
                            </div>

                            <div class="form-group">
                                <label for="password">
                                    <i class="zmdi zmdi-lock"></i>
                                </label>
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password" 
                                    placeholder="Password" 
                                    required 
                                    minlength="6" 
                                    title="Password must be at least 6 characters long"
                                >
                            </div>

                            <div class="form-group form-button">
                                <input 
                                    type="submit" 
                                    name="login_admin" 
                                    id="signin" 
                                    class="form-submit" 
                                    value="Log in"
                                >
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="./js/jquery.min.js"></script>
    <script src="./js/main.js"></script>
</body>
</html>
