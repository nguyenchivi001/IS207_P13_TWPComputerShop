<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['uid'])) {
  header("Location: ./signin.php");
}
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
require './header.php';
?>
<section class="section" id="checkout-section">
	<div class="container p-2">
		<div class="row-checkout rounded">
			<div class="col-100">
				<form id="checkout_form text-color">
					<div class="row-checkout">
					<div class="checkout-col p-2">
						<h3>Địa chỉ giao hàng</h3>
						<label for="fname" class="mt-2"><i class="fa fa-user" ></i> Tên đầy đủ</label>
						<input type="text" id="fname" class="form-control w-100" name="firstname" pattern="^[a-zA-Z ]+$">
						<label for="email" class="mt-2"><i class="fa fa-envelope"></i> Email</label>
						<input type="text" id="email" name="email" class="form-control w-100" pattern="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$" required>
						<label for="adr" class="mt-2"><i class="fa-solid fa-location-dot"></i> Địa chỉ</label>
						<input type="text" id="adr" name="address" class="form-control w-100" required>
						<label for="city" class="mt-2"><i class="fa fa-institution"></i> Thành Phố</label>
						<input type="text" id="city" name="city" class="form-control w-100" pattern="^[a-zA-Z ]+$" required>
                        <label for="zip" class="w-100 mt-2">Mã bưu điện</label>
                        <input type="text" id="zip" name="zip" class="form-control" pattern="^[0-9]{6}(?:-[0-9]{4})?$" required>
					</div>
					<div class="checkout-col p-2">
						<h3>Thanh toán</h3>
						<label for="fname" class="mt-2">Thẻ được chấp nhận</label>
						<div class="icon-container">
                        <i class="fa-brands fa-cc-paypal fa-2x" style="color: navy;"></i>
                        <i class="fa-brands fa-cc-apple-pay fa-2x" style="color: black;"></i>
                        <i class="fa-brands fa-cc-amazon-pay fa-2x" style="color: orange;"></i>
						</div>
						
						<label for="cname" class="mt-2">Tên người dùng </label>
						<input type="text" id="cname" name="cardname" class="form-control" pattern="^[a-zA-Z ]+$" required>
						
						<div class="form-group" id="card-number-field">
                        <label for="cardNumber" class="mt-2">Số thẻ</label>
                        <input type="text" class="form-control" id="cardNumber" name="cardNumber" required>
                    </div>
						<label for="expdate" class="mt-2">Ngày hết hạn</label>
						<input type="text" id="expdate" class="form-control" pattern="^((0[1-9])|(1[0-2]))\/(\d{2})$" required>
                        <label for="cvv" class="mt-2">CVV</label>
                        <input type="text" class="form-control" id="cvv" required>
					</div>
					</div>
                    <div class="d-flex justify-content-between align-items-center p-2">
                        <button class="btn btn-success">Thanh toán</button>
                    </div>		
				</form>	
                <h3 class="block p-4">
                    Tổng tiền:
                    <span><b></b></span>
                </h3>
            </div>
		</div>
	</div>
</section>
<?php require './footer.html'?>
