<?php require './header.php'?>
<section id="wishlist-section" class="container-fluid">
    <div class="table-responsive">
        <table id="wishlist" class="table table-hover table-striped rounded overflow-hidden shadow-sm" id="">
        <thead>
            <tr>
                <th style="width:50%" class="text-color">Sản phẩm</th>
                <th style="width:10%" class="text-color">Đơn giá</th>
                <th style="width:10%" class="text-color text-center">Tổng tiền</th>
                <th style="width:10%" class="text-color"></th>
                <th style="width:20%" class="text-color"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
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
                <td data-th="Price"><input type="text" class="form-control price" value="19000000" readonly="readonly"></td>
                <td data-th="Subtotal" class="text-center"><input type="text" class="form-control total" value="19000000" readonly="readonly"></td>
                <td class="actions" data-th="">
                <div class="btn-group">
                    <a href="#" class="btn remove-btn"><i class="fa-solid fa-trash"></i></a>		
                </div>							
                </td>
                <td class="actions" data-th="">
                <a href="#" id="product" class="btn btn-success">Chuyển sang giỏ hàng</a>
                </td>
            </tr>
        </tbody>
        <tfoot>
        <td><a class="btn primary-btn"><i class="fa fa-angle-left"></i> Tiếp tục mua sắm</a></td>
        <td colspan="2"></td>
        <td class="hidden-xs text-center"></td>
        <td></td>
        </tfoot>
        </table>
    </div>
</section>
<?php require './footer.html'?>