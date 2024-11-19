<?php require './header.php'?>
<section class="section">
  <div class="container-fluid ">	
      <div id="cart_checkout">
        <div class="table-responsive">
          <table id="cart" class="table table-hover table-striped rounded overflow-hidden shadow-sm" id="" >
              <thead>
              <tr>
                <th class="text-color" style="width:50%">Sản phẩm</th>
                <th class="text-color" style="width:10%">Đơn giá</th>
                <th class="text-color" style="width:8%">Số lượng</th>
                <th class="text-color text-center" style="width:7%">Tổng tiền</th>
                <th class="text-color" style="width:10%"></th>
                <th class="text-color" style="width:15%"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <!-- image, product name, description, price, quantity,subtotal, total will be replaced by dynamic code -->
                <td class="" >
                  <div class="row">
                    <div class="col-lg-6 product-line overflow-auto">
                      <img class="w-50" src="../Assets/img/product01.png"/>
                      <h4><a href="#" class="text-color">Laptop MSI A5M R5500U</a></h4>
                    </div>
                    <div class="col-lg-6 product-line overflow-auto">
                        <p class="fw-normal text-color">Description</p>
                    </div>
                  </div>
                </td>
  
                <td><input type="text" class="form-control price" value="19000000" readonly="readonly"></td>
                <td>
                  <input type="number" min="1" value="1" class="form-control">
                </td>
                <td class="text-center"><input type="text" class="form-control total" value="19000000" readonly="readonly"></td>
                <td>
                <div class="btn-group">
                  <a href="#" class="btn update-btn"><i class="fa fa-refresh"></i></a>
                  <a href="#" class="btn remove-btn "><i class="fa-solid fa-trash"></i></a>		
                </div>							
                </td>
                <td>
                  <a href="#" class="btn primary-btn text-color">Chuyển sang yêu thích <i class="fa fa-angle-right"></i> </a>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td><a href="" class="btn primary-btn texto-color"><i class="fa fa-angle-left"></i> Tiếp tục mua sắm</a></td>
                <td colspan="2" class=""></td>
                <td class="hidden-xs text-center"><b class="text-color">Tổng tiền: 19000000</b></td>
                <td>   
                  <a href="#" class="btn btn-success">Thanh toán</a>
                </td>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
  </div>
</section>	
<?php require './footer.html'?>
