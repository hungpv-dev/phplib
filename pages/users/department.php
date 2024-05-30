<?php
$id = getLastStringUri();
$department = (new Model('departments'))->find($id);
if (!$department) {
    header('/quan-ly-phong-ban');
}
$usersDepartment = (new Model('users'))->where('department_id', $id)->get();
$users = (new Model('users','u'))->select('u.*,d.name as d_name')->leftJoin('departments d','u.department_id','d.id')->get();
$departments = (new Model('departments'))->all();
?>
<!DOCTYPE html>
<html data-navigation-type="default" data-navbar-horizontal-shape="default" lang="en-US" dir="ltr" xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--    Tiêu đề-->
    <title>Quản lý phòng ban</title>

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
                    <li class="breadcrumb-item"><a href="/quan-ly-phong-ban">Quản lý phòng ban</a></li>
                    <li class="breadcrumb-item"><?= $department->name ?> (#<?= $department->id ?>)</li>
                </ol>
            </nav>
            <h2 class="text-bold text-body-emphasis mb-5"><?= $department->name ?> (#<?= $department->id ?>)</h2>
            <div>
                <!-- Search -->
                <div class="row align-items-center justify-content-between g-3 mb-4">
                    <div class="col col-auto">

                    </div>
                    <div class="col-auto">
                        <div class="d-flex align-items-center ">
                            <button class="btn btn-link text-body me-4 px-0"><span class="fa-solid fa-file-export fs-9 me-2"></span>Xuất File
                            </button>
                            <button class="btn btn-primary px-3" data-bs-toggle="modal" data-bs-target="#addModel">
                                <span class="fas fa-plus me-2"></span>Nhân viên
                            </button>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="department-id" value="<?=$id?>">

                <!-- Table -->
                <div class="mx-n4 mx-lg-n6 px-4 px-lg-6 mb-9 bg-body-emphasis border-y mt-2 position-relative top-1" id="list_users_container">
                    <div class="table-responsive scrollbar ms-n1 ps-1">
                        <table class="table table-hover table-sm fs-9 mb-0">
                            <thead>
                                <tr>
                                    <th class="sort align-middle text-center" scope="col" data-sort="stt" style="max-width:60px">#</th>
                                    <th class="sort align-middle text-start" scope="col" data-sort="customer" style="max-width:160px">Tên nhân viên</th>
                                    <th class="sort align-middle text-start" scope="col" data-sort="customer" style="max-width:160px">Email</th>
                                    <th class="sort align-middle text-start" scope="col" data-sort="role" style="max-width:160px">Trạng thái</th>
                                    <th class="sort align-middle text-start" scope="col" data-sort="status">Hành động</th>
                            </thead>

                            

                            <tbody class="list-data" id="data_table_body">
                                <?php if (empty($usersDepartment)) : ?>
                                    <tr>
                                        <td colspan="5">
                                            <h5 class="mt-1 text-center">Không có user nào trong phòng này cả</h5>
                                        </td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($usersDepartment as $user) : ?>
                                        <tr class="tr-clost-<?=$user->id?>">
                                            <td><?= $user->id ?></td>
                                            <td><a href="/quan-ly-nhan-vien/<?= $user->id ?>"><?= $user->name ?></a></td>
                                            <td><?= $user->email ?></td>
                                            <td><?= $user->status == 0 ? 'Hoạt động' : 'Ngưng hoạt động' ?></td>
                                            <td>
                                                <div class="position-relative">
                                                    <button data-id="<?= $user->id ?>" class="btn btn-delete btn-sm btn-phoenix-secondary text-info me-1 fs-10" title="Xóa khỏi phòng ban" type="button">
                                                        <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128H416L394.8 466.1z"></path></svg>
                                                    </button>
                                                </div>
                                                <!--  data-bs-toggle="modal" data-bs-target="#editModel" -->
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif ?>
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
                                <h5 class="modal-title" id="exampleModalLabel">Thêm nhân viên</h5>
                                <button class="btn p-1 closeButton" type="button" data-bs-dismiss="modal" aria-label="Close">
                                    <svg class="svg-inline--fa fa-xmark fs-9" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                        <path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form class="row g-3" id="formAdd" method="POST">
                                    <p class="m-0 mt-2 ps-2">----------------------------Nhân viên-----------------------------</p>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                            <select name="user_id" title="nhân viên" class="form-select data-value data-validate">
                                                <option value="" hidden>Chọn nhân viên</option>
                                                <?php foreach($users as $user): ?>
                                                    <option value="<?= $user->id ?>"><?= $user->name ?> (<?= $user->d_name ?? 'Chưa thuộc phòng ban nào' ?>)</option>
                                                <?php endforeach ?>
                                            </select>
                                            <label>Danh sách nhân viên</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-floating">
                                        <select title="phòng ban" name="department_id" class="form-select data-value data-validate">
                                                <option value="" hidden>Chọn phòng ban</option>
                                                <?php foreach($departments as $department): ?>
                                                    <option <?= $department->id == $id ? 'selected' : 'false' ?> value="<?= $department->id ?>"><?= $department->name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            <label>Danh sách phòng ban</label>
                                        </div>
                                    </div>

                                    
                                    <div class="col-12 gy-6">
                                        <div class="row g-3 justify-content-center">
                                            <div class="col-auto">
                                                <button type="reset" class="btn btn-close-model btn-secondary mx-1" data-bs-dismiss="modal">Huỷ
                                                </button>
                                                <button type="submit" class="btn btn-primary btn-submit mx-1" title="Thêm nhân viên">Thêm nhân viên</button>
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

            <script src="../inc/scripts/department.js"></script>
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