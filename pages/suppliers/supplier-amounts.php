<?php
$id = getLastStringUri();
$supplier = (new Model('suppliers'))->find($id);
if (!$supplier) {
    redirect('/quan-ly-nha-cung-cap');
}
?>
<!DOCTYPE html>
<html data-navigation-type="default" data-navbar-horizontal-shape="default" lang="en-US" dir="ltr" xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--    Tiêu đề-->
    <title>Quản lý công nợ</title>

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



        <input type="hidden" id="data-id" value="<?= $supplier->supplier_amount_id ?>">
        <!-- Nội dung chính được hiển thị-->
        <div class="content">
            <nav class="mb-2 d-flex align-items-center justify-content-between" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="/quan-ly-nha-cung-cap">Quản lý nhà cung cấp</a></li>
                    <li class="breadcrumb-item">Quản lý công nợ</li>
                    <li class="breadcrumb-item"><?= $supplier->name ?> (#<?= $supplier->id ?>)</li>
                </ol>
                <button class="btn btn-primary px-3" data-bs-toggle="modal" data-bs-target="#addModelAmount">
                    <span class="fas fa-plus me-2"></span>Thêm tài khoản công nợ
                </button>
            </nav>
            <h2 class="text-bold text-body-emphasis mb-5"><?= $supplier->name ?> (#<?= $supplier->id ?>)</h2>
            <div class="card-body">
                <h4 class="card-title mb-4">Chi tiết công nợ</h4>
                <div class="row gx-3">
                    <div class="col-12 col-sm-6 col-xl-6">
                        <div class="mb-4">
                            <div class="d-flex flex-wrap mb-2">
                                <h5 class="mb-0 text-body-highlight me-2">Số tiền tạm ứng ban đầu</h5>
                            </div>
                            <input type="text" class="form-control data-show" name="initial_advance_amount" disabled>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-6">
                        <div class="mb-4">
                            <div class="d-flex flex-wrap mb-2">
                                <h5 class="mb-0 text-body-highlight me-2">Số tiền tạm ứng hiện tại</h5>
                            </div>
                            <input type="text" class="form-control data-show" name="advance_amount" disabled>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-6">
                        <div class="mb-4">
                            <div class="d-flex flex-wrap mb-2">
                                <h5 class="mb-0 text-body-highlight me-2">Số nợ ban đầu</h5>
                            </div>
                            <input type="text" class="form-control data-show" name="initial_debt_amount" disabled>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-6">
                        <div class="mb-4">
                            <div class="d-flex flex-wrap mb-2">
                                <h5 class="mb-0 text-body-highlight me-2">Số nợ hiện tại</h5>
                            </div>
                            <input type="text" class="form-control data-show" name="debt_amount" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <!-- Search -->
                <div class="row align-items-center justify-content-between g-3 mb-4">
                    <div class="col col-auto">
                        <div class="search-box" style="width:100%">
                            <form id="form-search" class="row justify-content-start align-items-center g-2">
                                <div class="col-md-8">
                                    Từ ngày <input class="form-control" id="searchName" type="date" placeholder="Tìm kiếm theo tên..." aria-label="Search" /> đến nay
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
                            <button id="btnShowForm" class="btn btn-primary px-3" data-bs-toggle="modal" data-bs-target="#addModel">
                                <span class="fas fa-plus me-2"></span>Cập nhật công nợ
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <h5>Lịch sử cập nhật</h5>
                <div class="mx-n4 mx-lg-n6 px-4 px-lg-6 mb-9 bg-body-emphasis border-y mt-2 position-relative top-1" id="list_users_container">
                    <div class="table-responsive scrollbar ms-n1 ps-1">
                        <table class="table table-hover table-sm fs-9 mb-0">
                            <thead>
                                <tr>
                                    <th class="sort align-middle text-center" scope="col" data-sort="stt" style="max-width:60px">#</th>
                                    <th class="sort align-middle text-start" scope="col" data-sort="customer" style="max-width:160px">Tiền ứng ban đầu</th>
                                    <th class="sort align-middle text-start" scope="col" data-sort="customer" style="max-width:160px">Số tiền tạm ứng</th>
                                    <th class="sort align-middle text-start" scope="col" data-sort="email" style="max-width: 200px">Tiền nợ ban đầu</th>
                                    <th class="sort align-middle text-start" scope="col" data-sort="role" style="max-width:160px">Số tiền nợ</th>
                                    <th class="sort align-middle text-start" scope="col" data-sort="last_active" style="max-width: 200px">Lần cập nhật gần nhất</th>
                                    <th class="sort align-middle text-start" scope="col" data-sort="last_active" style="max-width: 200px">Ngày tạo</th>
                                    <th class="sort align-middle text-start" scope="col" data-sort="status">Hành động</th>
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
                    <button type="button" id="show-all" data-id="1" class="btn p-0 text-primary">Xem tất cả >></button>
                </div>
            </div>

            <!-- MODEL -->
            <div class="modal fade" id="addModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Sửa công nợ</h5>
                                <button class="btn p-1 closeButton" type="button" data-bs-dismiss="modal" aria-label="Close">
                                    <svg class="svg-inline--fa fa-xmark fs-9" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                        <path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form class="row g-3" id="formAdd" method="POST">
                                    <p class="m-0 mt-2 ps-2">-----------------------------Công nợ------------------------------</p>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control" name="initial_advance_amount" disabled type="text" placeholder="Số tiền tạm ứng ban đầu" />
                                            <label>Số tiền tạm ứng ban đầu</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control data-value data-validate" name="advance_amount" type="text" placeholder="Số tiền tạm ứng hiện tại" />
                                            <label>Số tiền tạm ứng hiện tại</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control" disabled name="initial_debt_amount" type="text" placeholder="Số nợ ban đầu" />
                                            <label>Số nợ ban đầu</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control data-value data-validate" name="debt_amount" type="text" placeholder="Số nợ hiện tại" />
                                            <label>Số nợ hiện tại</label>
                                        </div>
                                    </div>

                                    <div class="col-12 gy-6">
                                        <div class="row g-3 justify-content-center">
                                            <div class="col-auto">
                                                <button type="reset" class="btn btn-close-model btn-secondary mx-1" data-bs-dismiss="modal">Huỷ
                                                </button>
                                                <button type="submit" class="btn btn-primary btn-submit mx-1" title="Sửa công nợ">Sửa công nợ</button>
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
            <div class="modal fade" id="addModelAmount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Sửa công nợ</h5>
                                <button class="btn p-1 closeButton" type="button" data-bs-dismiss="modal" aria-label="Close">
                                    <svg class="svg-inline--fa fa-xmark fs-9" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                        <path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form class="row g-3" id="formAddAmount" method="POST">
                                    <p class="m-0 mt-2 ps-2">------------------------Tài khoản công nợ-------------------------</p>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control data-value data-validate" name="name" type="text" placeholder="tên công nợ" />
                                            <label>Họ và tên</label>
                                        </div>
                                    </div>
                                    <input type="hidden" id="edit-id">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control data-value data-validate" name="email" type="text" placeholder="email công nợ" />
                                            <label>Email</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <select name="status" id="" class="form-select data-value data-validate">
                                                <option value="0">Hoạt động</option>
                                                <option value="1">Khóa</option>
                                            </select>
                                            <label>Trạng thái</label>
                                        </div>
                                    </div>

                                    <input type="hidden" id="edit-id">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <select name="department_id" title="phòng ban" class="form-select data-value data-validate">
                                                <option value="">Chọn phòng ban</option>
                                                <?php foreach ($departments as $department) : ?>
                                                    <option value="<?= $department->id ?>"><?= $department->name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <label>Phòng ban</label>
                                        </div>
                                    </div>
                                    <div class="col-12 gy-6">
                                        <div class="row g-3 justify-content-center">
                                            <div class="col-auto">
                                                <button type="reset" class="btn btn-close-model btn-secondary mx-1" data-bs-dismiss="modal">Huỷ
                                                </button>
                                                <button type="submit" class="btn btn-primary btn-submit mx-1" title="Sửa công nợ">Sửa công nợ</button>
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

            <!-- <script src="../../inc/scripts/supplier-amounts.js"></script> -->
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