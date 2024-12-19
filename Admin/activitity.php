<?php 
function countRows($con, $table) {
    $con=OpenCon();
    $query = "SELECT COUNT(*) AS count FROM $table";
    $stmt = mysqli_prepare($con, $query);
    if ($stmt) {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        return $count;
    }
    CloseCon($con);

    return 0; 
}
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <p class="card-category">Tổng khách hàng</p>
                        <h3 class="card-title">
                            <?php 
                            $con=OpenCon();
                            echo countRows($con, 'user_info');
                            CloseCon($con);
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
        
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="fa-solid fa-table"></i>
                        </div>
                        <p class="card-category">Tổng phân loại</p>
                        <h3 class="card-title">
                            <?php 
                          $con=OpenCon();
                            echo countRows($con, 'categories'); 
                            CloseCon($con);
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
        
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="fa-solid fa-money-bills"></i>
                        </div>
                        <p class="card-category">Tổng hóa đơn</p>
                        <h3 class="card-title">
                            <?php 
                            $con=OpenCon();
                            echo countRows($con, 'orders_info'); 
                            CloseCon($con);
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
