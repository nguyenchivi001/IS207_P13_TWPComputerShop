<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

include "../Database/db_connection.php";

// Xóa thành viên nếu có yêu cầu
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $user_id = intval($_GET['user_id']); // Đảm bảo $user_id là số nguyên
$con = OpenCon(); // Sử dụng hàm OpenCon từ db.php

// Kiểm tra kết nối
if (!$con) {
    die("Không thể kết nối đến cơ sở dữ liệu.");
}
  // Sử dụng Prepared Statement để xóa dữ liệu
  $stmt = $con->prepare("DELETE FROM user_info WHERE user_id = ?");
  if ($stmt) {
      $stmt->bind_param("i", $user_id);

      if ($stmt->execute()) {
          echo "<script>alert('Xóa thành viên thành công!');</script>";
      } else {
          echo "<script>alert('Không thể xóa thành viên. Vui lòng thử lại sau!');</script>";
      }

      $stmt->close();
  } else {
      echo "<script>alert('Có lỗi xảy ra trong truy vấn SQL.');</script>";
  }
  CloseCon($con);
}
include "sidenav.php";
include "topheader.php";
?>

<!-- Giao diện Quản lý Thành viên -->
<div class="content">
    <div class="container-fluid">
        <div class="col-md-14">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Quản lý khách hàng</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive ps">
                        <table class="table tablesorter table-hover">
                            <thead class="text-primary">
                                <tr>
                                    <th>STT</th>
                                    <th>Họ</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>SĐT</th>
                                    <th>Địa chỉ</th>
                                    <th>Thành phố</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                               $con = OpenCon();
                               // Lấy danh sách thành viên
                               $stmt = $con->prepare("SELECT user_id, first_name, last_name, email, mobile, address1, address2 FROM user_info");
                               
                               if ($stmt) {
                                   $stmt->execute();
                                   $stmt->bind_result($user_id, $first_name, $last_name, $email, $mobile, $address1, $address2);
                                   $counter = 1; // Đếm số thứ tự
                                   
                                   while ($stmt->fetch()) {                                       
                                       echo "<tr>
                                           <td>{$counter}</td>
                                           <td>{$first_name}</td>
                                           <td>{$last_name}</td>
                                           <td>{$email}</td>
                                           <td>{$mobile}</td>
                                           <td>{$address1}</td>
                                           <td>{$address2}</td>
                                           <td>
                                             <a class='btn btn-success' href='editmembers.php?user_id=$user_id'>Edit</a>
                                           </td>
                                           <td>";
                                           
                                               if ($_SESSION['role'] == 'Manager') {
                                                 echo"
                                               <a class='btn btn-danger' href='managemembers.php?user_id={$user_id}&action=delete'>Xóa<div class='ripple-container'></div></a>
                                                    ";
                                                }
                                                echo "
                                                </td>
                                       </tr>";
                                       $counter++;
                                   }
                               
                                   $stmt->close();
                               } else {
                                   echo "<tr><td colspan='8'>Không thể lấy danh sách thành viên. Vui lòng thử lại sau.</td></tr>";
                               }
                               
                               CloseCon($con);
                               ?>
                            </tbody>
                        </table>
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 0px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>
