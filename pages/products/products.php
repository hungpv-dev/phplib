<?php
$categories = (new Model('categories'))->all();
$grades = (new Model('grades'))->all();
$units = (new Model('units'))->all();
$slumps = (new Model('slump'))->all();
$loaivattu = (new Model('loai_vat_tu'))->all();
?>
<!DOCTYPE html>
<html data-navigation-type="default" data-navbar-horizontal-shape="default" lang="en-US" dir="ltr" xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--    Tiêu đề-->
    <title>Quản lý sản phẩm & dịch vụ</title>

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



        <!-- Nội dung chính được hiển thị-->
        <div class="content">
            <nav class="mb-2" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                    <li class="breadcrumb-item">Quản lý sản phẩm & dịch vụ</li>
                </ol>
            </nav>
            <h2 class="text-bold text-body-emphasis mb-5">Quản lý sản phẩm & dịch vụ</h2>
            <div>
                <!-- Search -->
                <div class="row align-items-center justify-content-between g-3 mb-4">
                    <div class="col col-auto">
                        <div class="search-box" style="width:100%">
                            <form id="form-search" class="row justify-content-start g-2">
                                <div class="col-md-8">
                                    <input class="form-control" id="searchName" type="search" placeholder="Tìm kiếm theo tên..." aria-label="Search" />
                                    <select id="filterId" class="form-select">
                                        <option value="1">Sản phẩm</option>
                                        <option value="2">Dịch vụ</option>
                                    </select>
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
                                <span class="fas fa-plus me-2"></span>Sản phẩm & dịch vụ
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="mx-n4 mx-lg-n6 px-4 px-lg-6 mb-9 bg-body-emphasis border-y mt-2 position-relative top-1" id="list_users_container">
                    <div class="table-responsive scrollbar ms-n1 ps-1">
                        <table class="table table-hover table-sm fs-9 mb-0">
                            <thead>
                                <tr id="tr-render">
                                    <th class="sort align-middle text-center" scope="col" style="max-width:60px">#</th>
                                    <th class="sort align-middle text-start" scope="col" style="max-width:160px">Tên</th>
                                    <th class="sort align-middle text-start" scope="col" style="max-width:160px">Giá</th>
                                    <th class="sort align-middle text-start" scope="col" style="max-width: 200px">Mã bê tông</th>
                                    <th class="sort align-middle text-start" scope="col" style="max-width:160px">Mã cát</th>
                                    <th class="sort align-middle text-start" scope="col" style="max-width:160px">Mã xi măng</th>
                                    <th class="sort align-middle text-start" scope="col" style="max-width:160px">Mã phụ gia</th>
                                    <th class="sort align-middle text-start" scope="col" style="max-width:160px">Mã độ sụt</th>
                                    <th class="sort align-middle text-start" scope="col" style="max-width:160px">Đơn vị tính</th>
                                    <th class="sort align-middle text-start" scope="col" style="max-width:160px">Loại hình</th>
                                    <th class="sort align-middle text-start" scope="col" style="max-width:160px">Mô tả</th>
                                    <th class="sort align-middle text-start" scope="col" style="max-width: 200px">Ngày cập nhật</th>
                                    <th class="sort align-middle text-start" scope="col" style="max-width: 200px">Ngày tạo</th>
                                    <th class="sort align-middle text-start" scope="col">Hành động</th>
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
                                <h5 class="modal-title" id="exampleModalLabel">Thêm sản phẩm & dịch vụ</h5>
                                <button class="btn p-1 closeButton" type="button" data-bs-dismiss="modal" aria-label="Close">
                                    <svg class="svg-inline--fa fa-xmark fs-9" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                        <path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form class="row g-3" id="formAdd" method="POST">
                                    <p class="m-0 mt-2 ps-2">-----------------------Sản phẩm & dịch vụ------------------------</p>

                                    <div class="col-sm-6 col-md-12">
                                        <div class="form-floating">
                                            <select id="category_id" name="category_id" title="phòng ban" class="form-select data-value data-validate">
                                                <option value="" hidden>Danh mục sản phẩm</option>
                                                <?php foreach ($categories as $category) : ?>
                                                    <option value="<?= $category->id ?>"><?= $category->name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <label>Chọn danh mục</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 mb-2">
                                        <div class="form-floating">
                                            <input class="form-control data-value data-validate" name="name" type="text" placeholder="tên dịch vụ" />
                                            <label>Tên dịch vụ</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 mb-2">
                                        <div class="form-floating">
                                            <input class="form-control data-value data-validate" oninput="formatBalance(event)" name="price" type="text" placeholder="giá dịch vụ" />
                                            <label>Giá</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 mb-2">
                                        <div class="form-floating">
                                            <select title="đơn vị" name="unit_id" id="" class="form-select data-value data-validate">
                                                <option value="">Chọn đơn vị tính</option>
                                                <?php foreach ($units as $unit) : ?>
                                                    <option value="<?= $unit->id ?>"><?= $unit->name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <label>Đơn vị</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 mb-2">
                                        <div class="form-floating">
                                            <input class="form-control data-value" name="desc" type="text" placeholder="Mô tả" />
                                            <label>Mô tả</label>
                                        </div>
                                    </div>

                                    <div id="content-form-add" class="col-12 row mt-2 mx-auto">
                                        <div class="col-sm-6 col-md-6 mb-2">
                                            <div class="form-floating">
                                                <select class="form-select data-value data-validate" title="bê tông" name="grade_id">
                                                    <option value="" hidden>Chọn bê tông</option>
                                                    <?php foreach ($grades as $grade) : ?>
                                                        <option value="<?= $grade->id ?>"><?= $grade->name ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                                <label>Mác bê tông</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 mb-2">
                                            <div class="form-floating">
                                                <select class="form-select data-value data-validate" title="độ sụt" name="slump_id">
                                                    <option value="" hidden>Chọn độ sụt</option>
                                                    <?php foreach ($slumps as $slump) : ?>
                                                        <option value="<?= $slump->id ?>"><?= $slump->name ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                                <label>Mã độ sụt</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 mb-2">
                                            <div class="form-floating">
                                                <select title="vật tư" class="form-select data-value data-validate">
                                                    <option value="" hidden>Chọn vật tư</option>
                                                    <?php foreach($loaivattu as $lvt): ?>
                                                        <option value="<?= $lvt->id ?>"><?= $lvt->name ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                                <label>Chọn vật tự</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 gy-6">
                                        <div class="row g-3 justify-content-center">
                                            <div class="col-auto">
                                                <button type="reset" class="btn btn-close-model btn-secondary mx-1" data-bs-dismiss="modal">Huỷ
                                                </button>
                                                <button type="submit" class="btn btn-primary btn-submit mx-1" title="Thêm ngay">Thêm ngay</button>
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

            <div class="modal fade" id="editModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Sửa sản phẩm & dịch vụ</h5>
                                <button class="btn p-1 closeButton" type="button" data-bs-dismiss="modal" aria-label="Close">
                                    <svg class="svg-inline--fa fa-xmark fs-9" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                        <path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form class="row g-3" id="formEdit" method="POST">
                                    <p class="m-0 mt-2 ps-2">-----------------------Sản phẩm & dịch vụ------------------------</p>

                                    <div class="col-sm-6 col-md-12">
                                        <div class="form-floating">
                                            <select disabled name="category_id" title="phòng ban" class="form-select data-value data-validate">
                                                <option value="" hidden>Danh mục sản phẩm</option>
                                                <?php foreach ($categories as $category) : ?>
                                                    <option value="<?= $category->id ?>"><?= $category->name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <label>Chọn danh mục</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 mb-2">
                                        <div class="form-floating">
                                            <input class="form-control data-value data-validate" name="name" type="text" placeholder="tên dịch vụ" />
                                            <label>Tên dịch vụ</label>
                                        </div>
                                    </div>
                                    <input type="hidden" id="edit-id">
                                    <div class="col-sm-6 col-md-6 mb-2">
                                        <div class="form-floating">
                                            <input class="form-control data-value data-validate" oninput="formatBalance(event)" name="price" type="text" placeholder="giá dịch vụ" />
                                            <label>Giá</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 mb-2">
                                        <div class="form-floating">
                                            <select title="đơn vị" name="unit_id" id="" class="form-select data-value data-validate">
                                                <option value="">Chọn đơn vị tính</option>
                                                <?php foreach ($units as $unit) : ?>
                                                    <option value="<?= $unit->id ?>"><?= $unit->name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <label>Đơn vị</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6 mb-2">
                                        <div class="form-floating">
                                            <input class="form-control data-value" name="desc" type="text" placeholder="Mô tả" />
                                            <label>Mô tả</label>
                                        </div>
                                    </div>

                                    <div id="content-form-edit" class="col-12 row mt-2 mx-auto">
                                        <div class="col-sm-6 col-md-6 mb-2">
                                            <div class="form-floating">
                                                <select class="form-select data-value data-validate" title="bê tông" name="grade_id">
                                                    <option value="" hidden>Chọn bê tông</option>
                                                    <?php foreach ($grades as $grade) : ?>
                                                        <option value="<?= $grade->id ?>"><?= $grade->name ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                                <label>Mác bê tông</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 mb-2">
                                        <div class="form-floating">
                                            <select class="form-select data-value data-validate" title="độ sụt" name="slump_id">
                                                <option value="" hidden>Chọn độ sụt</option>
                                                <?php foreach ($slumps as $slump) : ?>
                                                    <option value="<?= $slump->id ?>"><?= $slump->name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <label>Mã độ sụt</label>
                                        </div>
                                    </div>
                            </div>

                            <div class="col-12 gy-6">
                                <div class="row g-3 justify-content-center">
                                    <div class="col-auto">
                                        <button type="reset" class="btn btn-close-model btn-secondary mx-1" data-bs-dismiss="modal">Huỷ
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-submit mx-1" title="Thêm ngay">Thêm ngay</button>
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
        <script src="./inc/scripts/products.js"></script>
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