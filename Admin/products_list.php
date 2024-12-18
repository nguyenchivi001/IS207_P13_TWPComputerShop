<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include "../Database/db_connection.php";
error_reporting(0);
if(isset($_GET['action']) && $_GET['action']!="" && $_GET['action']=='delete')
{
  $con=OpenCon();
 /*this is delet query*/
$product_id=$_GET['product_id'];
///////picture delete/////////
$result=mysqli_query($con,"select product_image from products where product_id='$product_id'")
or die("query is incorrect...");

list($picture)=mysqli_fetch_array($result);
$path="../product_images/$picture";

if(file_exists($path)==true)
{
  unlink($path);
}
else
{}
/*this is delet query*/
mysqli_query($con,"delete from products where product_id='$product_id'")or die("query is incorrect...");
CloseCon($con);
}

///pagination

$page=$_GET['page'];

if($page=="" || $page=="1")
{
$page1=0;	
}
else
{
$page1=($page*10)-10;	
} 
include "sidenav.php";
include "topheader.php";
?>

      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
        
        
         <div class="col-md-14">
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title"> Danh sách sản phẩm</h4>
                
              </div>
              <div class="card-body">
                <div class="table-responsive ps">
                  <table class="table tablesorter " id="page1">
                    <thead class=" text-primary">
                      <tr><th>Ảnh</th><th>Tên sản phẩm</th><th>Đơn giá</th><th>
                      <?php
                      if ($_SESSION['role'] == 'Manager') {
                        echo'
                            <a class=" btn btn-primary" href="add_product.php">Thêm mới</a>
                        ';
                    
                      }
                      ?>
	                  </th></tr></thead>
                    <tbody>
                      <?php 
                        $con=OpenCon();
                        $result=mysqli_query($con,"select product_id,product_image, product_title,product_price from products  where  product_cat=1 or product_cat=2 or product_cat=3 Limit $page1,12")or die ("query 1 incorrect.....");

                        while(list($product_id,$image,$product_name,$price)=mysqli_fetch_array($result))
                        {
                          $substr = substr($product_name,0,36);
                          // $price = round($price*0.014,2);
                        echo "<tr><td><img src='../Assets/product_images/$image' style='width:50px; height:50px; border:groove #000'></td><td>$substr</td>
                        <td>$price</td>
                        <td> ";
                    
                      if ($_SESSION['role'] == 'Manager') {
                        echo"
                        <a class=' btn btn-success' href='edit_product.php?product_id=$product_id'>Edit</a>
                        <a class=' btn btn-danger' href='products_list.php?product_id=$product_id&action=delete'>Delete</a>
                        ";
                    
                      }
                    echo "
                        
                        </td></tr>";
                        }
                        ?>
                    </tbody>
                  </table>
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
              </div>
            </div>
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item">
                  <a class="page-link" href="#" aria-label="Trước">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Trước</span>
                  </a>
                </li>
                 <?php 
                 $con=OpenCon();
                $paging=mysqli_query($con,"select product_id,product_image, product_title,product_price from products");
                $count=mysqli_num_rows($paging);

                $a=$count/10;
                $a=ceil($a);
                
                for($b=1; $b<=$a;$b++)
                {
                ?> 
                <li class="page-item"><a class="page-link" href="products_list.php?page=<?php echo $b;?>"><?php echo $b." ";?></a></li>
                <?php	
}
              CloseCon($con);
?>
                <li class="page-item">
                  <a class="page-link" href="#" aria-label="Sau">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Sau</span>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
      <?php
include "footer.php";
?>
