<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "../Database/db_connection.php";

include "sidenav.php";
include "topheader.php";
include "activitity.php";
function fetchData($con, $sql, $params = [])
{
    $con=OpenCon();
    $stmt = $con->prepare($sql);
    if (!empty($params)) {
        $types = str_repeat("s", count($params)); 
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result();
}

?>
<!-- End Navbar -->
<div class="content">
    <div class="container-fluid">
        <div class="panel-body">
            <?php
            if (isset($_POST['success'])) {
                echo "
                <div class='col-md-12 col-xs-12' id='product_msg'>
                    <div class='alert alert-success'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>
                        <b>Sản phẩm đã được thêm..!</b>
                    </div>
                </div>";
            }
            ?>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Tổng quan doanh thu</h4>
                </div>
                <div class="card-body">
                    <div id="chart">
                        <canvas id="salesChart"></canvas>
                    </div>
                    <button id="toggleChartType" class="btn btn-primary mt-3">Biểu đồ tròn</button>
                </div>
            </div>
        </div>
        <!-- Danh sách thành viên -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Danh sách thành viên</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="text-primary">
                                <tr>
                                    <th>ID</th>
                                    <th>Họ</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <!-- <th>Mật khẩu</th> -->
                                    <th>SĐT</th>
                                    <th>Địa chỉ</th>
                                    <th>Thành phố</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $con = OpenCon();
                                $result = fetchData($con, "SELECT * FROM user_info");
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                            <td>{$row['user_id']}</td>
                                            <td>{$row['last_name']}</td>
                                            <td>{$row['first_name']}</td>
                                            <td>{$row['email']}</td>
                                            <td>{$row['mobile']}</td>
                                            <td>{$row['address1']}</td>
                                            <td>{$row['address2']}</td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='8' class='text-center'>Không có dữ liệu</td></tr>";
                                }
                                CloseCon($con);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách phân loại -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Danh sách phân loại</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="text-primary">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên phân loại</th>
                                    <th>Số lượng sản phẩm</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = fetchData($con, "SELECT c.cat_id, c.cat_title, COUNT(p.product_id) AS count_items 
                                                           FROM categories c 
                                                           LEFT JOIN products p ON c.cat_id = p.product_cat 
                                                           GROUP BY c.cat_id, c.cat_title");
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                            <td>{$row['cat_id']}</td>
                                            <td>{$row['cat_title']}</td>
                                            <td>{$row['count_items']}</td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center'>Không có dữ liệu</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách hãng -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Danh sách hãng</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="text-primary">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên hãng</th>
                                    <th>Số lượng sản phẩm</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = fetchData($con, "SELECT b.brand_id, b.brand_title, COUNT(p.product_id) AS count_items 
                                                           FROM brands b 
                                                           LEFT JOIN products p ON b.brand_id = p.product_brand 
                                                           GROUP BY b.brand_id, b.brand_title");
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                            <td>{$row['brand_id']}</td>
                                            <td>{$row['brand_title']}</td>
                                            <td>{$row['count_items']}</td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center'>Không có dữ liệu</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
    $con = OpenCon();
    $query = "SELECT SUM(amt) AS total_amout, cat_title 
        FROM categories, products, order_products 
        WHERE categories.cat_id = products.product_cat 
        AND products.product_id = order_products.product_id 
        GROUP BY cat_title 
        ORDER BY total_amout DESC";
    $result = $con->query($query);
    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                'category' => $row["cat_title"],
                'amount' => $row["total_amout"]
            ];
        }
    }
    $jsonData = json_encode($data);
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    try {
        const phpData = <?php echo $jsonData; ?>;

        if (!phpData || phpData.length === 0) {
            console.warn("No data available for the chart.");
            return;
        }

        const labels = phpData.map(item => item.category);
        const amounts = phpData.map(item => item.amount);

        const data = {
            labels: labels,
            datasets: [
                {
                    label: "Doanh thu (VNĐ)",
                    data: amounts,
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1
                }
            ]
        };

        const options = {
            responsive: true,
            plugins: {
                legend: {
                    position: "top"
                },
                title: {
                    display: true,
                    text: "Thống kê doanh thu theo danh mục sản phẩm"
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        const ctx = document.getElementById("salesChart").getContext("2d");

        // Initial chart configuration - bar chart
        let chartType = "bar";
        let chart = new Chart(ctx, {
            type: chartType,
            data: data,
            options: options
        });

        const toggleButton = document.getElementById("toggleChartType");
        toggleButton.addEventListener("click", function () {
            chartType = chartType === "bar" ? "pie" : "bar";

            if (chartType === "pie") {
                document.getElementById("chart").style.width = "400px"; 
                document.getElementById("chart").style.margin = "auto"; 

                const colors = [
                    "rgba(255, 159, 64, 0.6)", // Orange
                    "rgba(255, 99, 132, 0.6)",  // Red
                    "rgba(54, 162, 235, 0.6)",  // Blue
                ];

                const data = {
                    labels: labels,
                    datasets: [
                        {
                            data: amounts,
                            backgroundColor: colors.slice(0, phpData.length),
                            borderWidth: 1
                        }
                    ]
                };
    
                const options = {
                    title: {
                        display: true,
                        text: "Thống kê doanh thu theo danh mục sản phẩm"
                    }
                };
                chart.destroy();
    
                chart = new Chart(ctx, {
                    type: chartType,
                    data: data,
                    options: options
                });
                
            } else {
                document.getElementById("chart").style.width = "";
                chart.destroy();
    
                chart = new Chart(ctx, {
                    type: chartType,
                    data: data,
                    options: options
                });
            }

            // Update button text based on current chart type
            toggleButton.textContent = chartType === "bar" ? "Biểu đồ tròn" : "Biểu đồ cột";
        });

    } catch (error) {
        console.error("Error initializing chart:", error);
    }
});
</script>
