<?php
$id = getLastStringUri();
$quote = (new Model('quotes'))->find($id);
$customer = (new Model('customers'))->find($quote->customer_id);
if (!$quote || !$customer) {
    redirect('/quan-ly-khach-hang');
}
$units = (new Model('units'))->all();
?>
<!DOCTYPE html>
<html data-navigation-type="default" data-navbar-horizontal-shape="default" lang="en-US" dir="ltr" xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--    Tiêu đề-->
    <title>Quản lý chi tiết báo giá</title>

    <!--    Favicons-->
    <?php include 'inc/favicons.php' ?>

    <!--    Stylesheets-->
    <?php include 'inc/css.php' ?>
</head>

<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <!--    menu và header-->
        <?php include 'inc/menu.php' ?>
        <?php include 'inc/header.php' ?>
        <!-- Phần chỉnh sửa thông tin sản phẩm-->

        <input type="hidden" id="data-id" value="<?= $id ?>">

        <!-- Nội dung chính được hiển thị-->
        <div class="content">
            <nav class="mb-2" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="/quan-ly-bao-gia/<?= $customer->id ?>">Quản lý báo giá: <?= $customer->name ?> (#<?= $customer->id ?>)</a></li>
                    <li class="breadcrumb-item">Quản lý chi tiết báo giá</li>
                </ol>
            </nav>
            <h2 class="text-bold text-body-emphasis mb-5">Quản lý chi tiết báo giá</h2>
            <div>
                <!-- Search -->
                <div class="row align-items-center justify-content-between g-3 mb-4">
                    <div class="col col-auto">
                        <div class="search-box" style="width:100%">
                            <form id="form-search" class="row justify-content-start g-2">
                                <div class="col-md-8">
                                    <input class="form-control" id="searchName" type="search" placeholder="Tìm kiếm theo tên..." aria-label="Search" />
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-primary px-3"><span class="fa-solid fas fa-search fs-9"></span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex align-items-center ">
                            <button class="btn btn-link text-body me-4 px-0"><span class="fa-solid fa-file-export fs-9 me-2"></span>Xuất File
                            </button>
                            <button class="btn btn-primary px-3" data-bs-toggle="modal" data-bs-target="#addModel">
                                <span class="fas fa-plus me-2"></span>Thêm sản phẩm & dịch vụ
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="mx-n4 mx-lg-n6 px-4 px-lg-6 mb-9 bg-body-emphasis border-y mt-2 position-relative top-1" id="list_users_container">
                    <div class="table-responsive scrollbar ms-n1 ps-1">
                        <table class="table table-hover table-sm fs-9 mb-0">
                            <thead>
                                <tr>
                                    <th class="sort align-middle text-center" style="max-width:60px">#</th>
                                    <th class="sort align-middle text-center" style="max-width:160px">Sản phẩm & Dịch vụ</th>
                                    <th class="sort align-middle text-center" style="max-width:160px">Số lượng</th>
                                    <th class="sort align-middle text-center" style="max-width: 200px">Đơn vị tính</th>
                                    <th class="sort align-middle text-center" style="max-width:160px">Giá thành</th>
                                    <th class="sort align-middle text-center" style="max-width: 200px">Tổng tiền</th>
                                    <th class="sort align-middle text-center" style="max-width: 200px">Ghi chú</th>
                                    <th class="sort align-middle text-center">Hành động</th>
                                </tr>
                            </thead>

                            <tr class="loading-data">
                                <td class="text-center" colspan="12">
                                    <div class="spinner-border text-info spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span>
                                    </div>
                                </td>
                            </tr>

                            <tbody class="list-data" id="data_table_body">
                                <tr></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="paginations"></div>
                </div>
            </div>

            <!-- MODEL -->
            <div class="modal fade" id="addModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Thêm chi tiết báo giá</h5>
                                <button class="btn p-1 closeButton" type="button" data-bs-dismiss="modal" aria-label="Close">
                                    <svg class="svg-inline--fa fa-xmark fs-9" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                        <path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form class="row g-3" id="formAdd" method="POST">
                                    <p class="m-0 mt-2 ps-2">--------------------------Chi tiết báo giá--------------------------</p>
                                    <input type="hidden" name="quote_id" class="data-value" value="<?= $id ?>">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <select id="changeProSer" title="loại hình" class="form-select data-validate">
                                                <option value="" hidden>Lựa chọn loại hình</option>
                                                <option value="1">Sản phẩm</option>
                                                <option value="2">Dịch vụ</option>
                                            </select>
                                            <label>Loại hình</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <select id="showList" name="product_id" title="sản phẩm dịch vụ" class="form-select data-value data-validate" disabled>
                                                <option value="" hidden>Chọn SP & DV</option>
                                            </select>
                                            <label>Sản phẩm & dịch vụ</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input type="number" id="showQuantity" name="quantity" class="form-control data-validate data-value" min="1" value="1" placeholder="số lượng">
                                            <label>Số lượng</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <select id="showUnit" name="unit_id" title="đơn vị tính" disabled class="form-select data-value">
                                                <option value="" hidden>Đơn vị tính</option>
                                                <?php foreach($units as $unit): ?>
                                                    <option value="<?= $unit->id ?>" hidden><?= $unit->name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <label>Đơn vị tính</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input type="text" id="showPrice" name="price" class="form-control data-value data-validate" oninput="formatBalance(event)" placeholder="giá thành">
                                            <label>Giá thành</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input type="text" id="showTotal" disabled name="total" value="0" class="form-control data-value" placeholder="tổng tiền">
                                            <label>Tổng tiền</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-12">
                                        <div class="form-floating">
                                            <textarea name="note" class="form-control data-value" placeholder="ghi chú"></textarea>
                                            <label>Ghi chú</label>
                                        </div>
                                    </div>

                                    <div class="col-12 gy-6">
                                        <div class="row g-3 justify-content-center">
                                            <div class="col-auto">
                                                <button type="reset" class="btn btn-close-model btn-secondary mx-1" data-bs-dismiss="modal">Huỷ
                                                </button>
                                                <button type="submit" class="btn btn-primary btn-submit mx-1" title="Thêm chi tiết báo giá">Thêm chi tiết báo giá</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODEL-->

            <!-- MODEL -->
            <div class="modal fade" id="editModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Sửa chi tiết báo giá</h5>
                                <button class="btn p-1 closeButton" type="button" data-bs-dismiss="modal" aria-label="Close">
                                    <svg class="svg-inline--fa fa-xmark fs-9" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                        <path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form class="row g-3" id="formEdit" method="POST">
                                    <p class="m-0 mt-2 ps-2">--------------------------Chi tiết báo giá--------------------------</p>
                                    <input type="hidden" name="quote_id" class="data-value" value="<?= $id ?>">
                                    <input type="hidden" id="data-id">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <select name="category_id" disabled title="loại hình" class="form-select data-validate">
                                                <option value="" hidden>Lựa chọn loại hình</option>
                                                <option value="1">Sản phẩm</option>
                                                <option value="3">Sản phẩm</option>
                                                <option value="2">Dịch vụ</option>
                                            </select>
                                            <label>Loại hình</label>
                                        </div>
                                    </div>
                                    <input type="hidden" id="edit-id">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" disabled name="product_name">
                                            <label>Sản phẩm & dịch vụ</label>
                                        </div>
                                    </div>
                                    <input type="hidden" class="data-value" name="product_id">

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input type="number" id="showQuantityE" name="quantity" class="form-control data-validate data-value" min="1" value="1" placeholder="số lượng">
                                            <label>Số lượng</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <select id="showUnit" name="unit_id" title="đơn vị tính" disabled class="form-select data-value">
                                                <option value="" hidden>Đơn vị tính</option>
                                                <?php foreach($units as $unit): ?>
                                                    <option value="<?= $unit->id ?>" hidden><?= $unit->name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <label>Đơn vị tính</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input type="text" id="showPriceE" name="price" class="form-control data-value data-validate" oninput="formatBalance(event)" placeholder="giá thành">
                                            <label>Giá thành</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input type="text" id="showTotalE" disabled name="total" value="0" class="form-control data-value" placeholder="tổng tiền">
                                            <label>Tổng tiền</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-12">
                                        <div class="form-floating">
                                            <textarea name="note" class="form-control data-value" placeholder="ghi chú"></textarea>
                                            <label>Ghi chú</label>
                                        </div>
                                    </div>

                                    <div class="col-12 gy-6">
                                        <div class="row g-3 justify-content-center">
                                            <div class="col-auto">
                                                <button type="reset" class="btn btn-close-model btn-secondary mx-1" data-bs-dismiss="modal">Huỷ
                                                </button>
                                                <button type="submit" class="btn btn-primary btn-submit mx-1" title="Sửa chi tiết báo giá">Sửa chi tiết báo giá</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="../inc/scripts/quote_details.js"></script>
            <!-- Footer-->
            <?php include 'inc/footer.php' ?>
        </div>
        <script>
            var navbarTopStyle = window.config.config.phoenixNavbarTopStyle;
            var navbarTop = document.querySelector('.navbar-top');
            if (navbarTopStyle === 'darker') {
                navbarTop.setAttribute('data-navbar-appearance', 'darker');
            }

            var navbarVerticalStyle = window.config.config.phoenixNavbarVerticalStyle;
            var navbarVertical = document.querySelector('.navbar-vertical');
            if (navbarVertical && navbarVerticalStyle === 'darker') {
                navbarVertical.setAttribute('data-navbar-appearance', 'darker');
            }
        </script>

        <?php include 'inc/js.php' ?>

</body>

</html>