<?php 
include"db.php";

function countRows($con, $table) {
    $query = "SELECT COUNT(*) AS count FROM $table";
    $stmt = mysqli_prepare($con, $query);
    if ($stmt) {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        return $count;
    }
    return 0; 
}
?>

<div class="row" style="padding-top: 10vh;">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                </div>
                <p class="card-category">Tổng thành viên</p>
                <h3 class="card-title">
                    <?php echo countRows($con, 'user_info'); ?>
                </h3>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">store</i>
                </div>
                <p class="card-category">Tổng phân loại</p>
                <h3 class="card-title">
                    <?php echo countRows($con, 'categories'); ?>
                </h3>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">info_outline</i>
                </div>
                <p class="card-category">Tổng khách mua</p>
                <h3 class="card-title">
                    <?php echo countRows($con, 'user_info'); ?>
                </h3>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
                <div class="card-icon">
                    <i class="fa fa-twitter"></i>
                </div>
                <p class="card-category">Tổng hóa đơn</p>
                <h3 class="card-title">
                    <?php echo countRows($con, 'orders_info'); ?>
                </h3>
            </div>
        </div>
    </div>
</div>
