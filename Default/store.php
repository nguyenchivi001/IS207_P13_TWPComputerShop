<?php
include 'header.php';
?>

<link rel="stylesheet" href="css/store.css">
<div class="main bg-light py-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <aside class="col-lg-3 mb-4">
                <!-- Categories -->
                <div id="get_category" class="mb-4">
                    <!-- Categories will be loaded dynamically -->
                </div>
                <!-- /Categories -->

                <!-- Popular Products -->
                <div class="mb-4">
                    <h5 class="fw-bold">Sản phẩm bán chạy</h5>
                    <div id="get_product_home">
                        <!-- Product widgets will be dynamically loaded -->
                    </div>
                </div>
            </aside>
            <!-- /Sidebar -->

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Store Filters -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center">
                        <label class="me-2">
                            Sort By:
                            <select class="form-select form-select-sm">
                                <option value="0">Popular</option>
                                <option value="1">Position</option>
                            </select>
                        </label>
                        <label>
                            Show:
                            <select class="form-select form-select-sm">
                                <option value="20">20</option>
                                <option value="50">50</option>
                            </select>
                        </label>
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-outline-secondary btn-sm active me-2">
                            <i class="fas fa-th"></i>
                        </button>
                        <button class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-th-list"></i>
                        </button>
                    </div>
                </div>
                <!-- /Store Filters -->

                <!-- Products -->
                <div class="row gy-4" id="product-row">
                    <div class="col-12" id="product_msg">
                        <!-- Product messages or alerts -->
                    </div>
                    <div id="get_product" cid="1">
                        <!-- Products will be loaded dynamically via Ajax -->
                    </div>
                </div>
                <!-- /Products -->

                <!-- Pagination -->
                <nav class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item">
                            <a class="page-link" href="#aside">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /Pagination -->
            </div>
            <!-- /Main Content -->
        </div>
    </div>
</div>

<?php
include "newsletter.html";
include "footer.html";
?>
