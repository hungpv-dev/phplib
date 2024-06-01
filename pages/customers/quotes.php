<?php
$id = getLastStringUri();
$customer = (new Model('customers'))->find($id);
$status = (new Model('quote_status'))->all();
if (!$customer) {
    redirect('/quan-ly-khach-hang');
}
?>
<!DOCTYPE html>
<html data-navigation-type="default" data-navbar-horizontal-shape="default" lang="en-US" dir="ltr" xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--    Tiêu đề-->
    <title>Quản lý báo giá</title>

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
                    <li class="breadcrumb-item">Quản lý báo giá</li>
                    <li class="breadcrumb-item">Khách hàng: <a href="/quan-ly-khach-hang"><?= $customer->name ?> (#<?= $id ?>)</a></li>
                </ol>
            </nav>
            <h2 class="text-bold text-body-emphasis mb-5"><?= $customer->name ?> (#<?= $id ?>)</h2>
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
                        <div class="d-flex align-items-center">
                            <button class="btn btn-link text-body me-4 px-0"><span class="fa-solid fa-file-export fs-9 me-2"></span>Xuất File
                            </button>
                            <button class="btn btn-primary px-3" data-bs-toggle="modal" data-bs-target="#addModel">
                                <span class="fas fa-plus me-2"></span>Báo giá
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <h5>Danh sách báo giá</h5>
                <div class="mx-n4 mx-lg-n6 px-4 px-lg-6 mb-9 bg-body-emphasis border-y mt-2 position-relative top-1" id="list_users_container">
                    <div class="table-responsive scrollbar ms-n1 ps-1">
                        <table class="table table-hover table-sm fs-9 mb-0">
                            <thead>
                                <tr>
                                    <th class="sort align-middle text-center" style="max-width:60px">#</th>
                                    <th class="sort align-middle text-center" style="max-width:160px">Nhân viên thêm</th>
                                    <th class="sort align-middle text-center" style="max-width: 200px">Số sản phẩm & dịch vụ</th>
                                    <th class="sort align-middle text-center" style="max-width:160px">Tổng tiền</th>
                                    <th class="sort align-middle text-center" style="max-width:160px">Tên người nhận</th>
                                    <th class="sort align-middle text-center" style="max-width:160px">SĐT nhận hàng</th>
                                    <th class="sort align-middle text-center" style="max-width:160px">Địa chỉ nhận hàng</th>
                                    <th class="sort align-middle text-center" style="max-width:160px">Trạng thái</th>
                                    <th class="sort align-middle text-center" style="max-width:160px">Ngày tạo</th>
                                    <th class="sort align-middle text-center">Hành động</th>
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
                                <h5 class="modal-title" id="exampleModalLabel">Thêm báo giá</h5>
                                <button class="btn p-1 closeButton" type="button" data-bs-dismiss="modal" aria-label="Close">
                                    <svg class="svg-inline--fa fa-xmark fs-9" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                        <path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form class="row g-3" id="formAdd" method="POST">
                                    <p class="m-0 mt-2 ps-2">------------------------------Báo giá------------------------------</p>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control" disabled value="<?= $_SESSION['authentication']->name ?>" type="text" />
                                            <label>Nhân viên thêm báo giá</label>
                                        </div>
                                    </div>
                                    <input type="hidden" class="data-value" name="customer_id" value="<?= $customer->id ?>">
                                    <input type="hidden" class="data-value" name="user_id" value="<?= $_SESSION['authentication']->id ?>">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control" disabled value="<?= $customer->name ?>" type="text" />
                                            <label>Khách hàng</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control data-value data-validate" value="<?= $customer->name ?>" name="consignee_name" type="text" placeholder="tên người nhận" />
                                            <label>Tên người nhận</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control data-value data-validate" value="<?= $customer->phone ?>" name="consignee_phone" type="text" placeholder="sđt người nhận" />
                                            <label>SĐT người nhận</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control data-value data-validate" value="<?= $customer->address ?>" name="consignee_address" type="text" placeholder="địa chỉ nhận hàng" />
                                            <label>Địa chỉ nhận hàng</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <select disabled class="form-select data-value" name="status">
                                                <?php foreach ($status as $s) : ?>
                                                    <option value="<?= $s->id ?>"><?= $s->name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <label>Trạng thái</label>
                                        </div>
                                    </div>

                                    <div class="col-12 gy-6">
                                        <div class="row g-3 justify-content-center">
                                            <div class="col-auto">
                                                <button type="reset" class="btn btn-close-model btn-secondary mx-1" data-bs-dismiss="modal">Huỷ
                                                </button>
                                                <button type="submit" class="btn btn-primary btn-submit mx-1" title="Thêm báo giá">Thêm báo giá</button>
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
                                <h5 class="modal-title" id="exampleModalLabel">Sửa báo giá</h5>
                                <button class="btn p-1 closeButton" type="button" data-bs-dismiss="modal" aria-label="Close">
                                    <svg class="svg-inline--fa fa-xmark fs-9" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                        <path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form class="row g-3" id="formEdit" method="POST">
                                    <p class="m-0 mt-2 ps-2">------------------------------Báo giá------------------------------</p>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control" id="edit-user" disabled value="" type="text" />
                                            <label>Nhân viên thêm báo giá</label>
                                        </div>
                                    </div>
                                    <input type="hidden" id="edit-id">
                                    <input type="hidden" class="data-value" name="customer_id" value="<?= $customer->id ?>">
                                    <input type="hidden" class="data-value" name="user_id" value="<?= $_SESSION['authentication']->id ?>">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control" disabled value="<?= $customer->name ?>" type="text" />
                                            <label>Khách hàng</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control data-value data-validate" value="<?= $customer->name ?>" name="consignee_name" type="text" placeholder="tên người nhận" />
                                            <label>Tên người nhận</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control data-value data-validate" value="<?= $customer->phone ?>" name="consignee_phone" type="text" placeholder="sđt người nhận" />
                                            <label>SĐT người nhận</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control data-value data-validate" value="<?= $customer->address ?>" name="consignee_address" type="text" placeholder="địa chỉ nhận hàng" />
                                            <label>Địa chỉ nhận hàng</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select data-value" name="status">
                                                <?php foreach ($status as $s) : ?>
                                                    <option value="<?= $s->id ?>"><?= $s->name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <label>Trạng thái</label>
                                        </div>
                                    </div>

                                    <div class="col-12 gy-6">
                                        <div class="row g-3 justify-content-center">
                                            <div class="col-auto">
                                                <button type="reset" class="btn btn-close-model btn-secondary mx-1" data-bs-dismiss="modal">Huỷ
                                                </button>
                                                <button type="submit" class="btn btn-primary btn-submit mx-1" title="Sửa báo giá">Sửa báo giá</button>
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
            <script src="../inc/scripts/quotes.js"></script>
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