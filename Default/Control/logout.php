<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }    
    session_unset();
    session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <meta http-equiv="refresh" content="0;url=../index.php">
</head>
<body>
    <p>Đang quay về trang chủ...</p>
</body>
</html>
