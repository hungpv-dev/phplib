<?php
$id = getLastStringUri();
$user = (new Model('users'))->find($id);
if(!$user){
    redirect('/quan-ly-nhan-vien');
}
$listActive = (new Model('user_active_logs'))->where('user_id', $id)->orderBy('id', 'desc')->get();
foreach ($listActive as $active) {
    $active->created_at = (new DateTime($active->created_at))->format('H:i d-m-Y');
}
$roles = (new Model('roles'))->all();
$userRole = (new Model('user_role'))->where('user_id',$id)->get();
$userRoleId = array_map(function($role){
    return $role->role_id;
},$userRole);
?>
<!DOCTYPE html>
<html data-navigation-type="default" data-navbar-horizontal-shape="default" lang="en-US" dir="ltr" xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--    Tiêu đề-->
    <title>Quản lý nhân viên</title>

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
                    <li class="breadcrumb-item"><a href="/quan-ly-nhan-vien">Quản lý nhân viên</a></li>
                    <li class="breadcrumb-item"><?= $user->name ?> (#<?= $user->id ?>)</li>
                </ol>
            </nav>
            <h2 class="text-bold text-body-emphasis mb-5"><?= $user->name ?> (#<?= $user->id ?>)</h2>
            <div>
                <!-- Search -->
                <div class="row align-items-center justify-content-between g-3 mb-4">
                    <div class="col col-auto">


                    </div>
                    <div class="col-auto">
                        <div class="d-flex align-items-center ">
                            <button class="btn btn-primary px-3" data-bs-toggle="modal" data-bs-target="#addModel">
                                <span class="fas fa-plus me-2"></span>Kiểm tra quyền
                            </button>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="user-id" value="<?= $id ?>">

                <!-- Table -->
                <div class="mx-n4 mx-lg-n6 px-4 px-lg-6 mb-9 bg-body-emphasis border-y mt-2 position-relative top-1" id="list_users_container">
                    <div class="table-responsive scrollbar ms-n1 ps-1">
                        <table class="table table-hover table-sm fs-9 mb-0">
                            <thead>
                                <tr>
                                    <th class="sort align-middle text-center" scope="col" data-sort="stt" style="max-width:60px">#</th>
                                    <th class="sort align-middle text-start" scope="col" data-sort="customer" style="max-width:160px">Mã nhân viên</th>
                                    <th class="sort align-middle text-start" scope="col" data-sort="customer" style="max-width:160px">Hành động</th>
                                    <th class="sort align-middle text-start" scope="col" data-sort="email" style="max-width: 200px">Thời gian</th>
                                </tr>
                            </thead>

                            <tbody class="list-data" id="data_table_body">
                                <?php foreach ($listActive as $active) : ?>
                                    <tr>
                                        <td><?= $active->id ?></td>
                                        <td><?= $active->user_id ?></td>
                                        <td><?= $active->detail ?></td>
                                        <td><?= $active->created_at ?></td>
                                    </tr>
                                <?php endforeach ?>
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
                                <h5 class="modal-title" id="exampleModalLabel">Quyền của nhân viên</h5>
                                <button class="btn p-1 closeButton" type="button" data-bs-dismiss="modal" aria-label="Close">
                                    <svg class="svg-inline--fa fa-xmark fs-9" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                        <path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form class="row g-3" id="formAdd" method="POST">
                                    <div>
                                        <div class="input-group-text">
                                            <input class="form-control input-search" placeholder="Tìm kiếm quyền ở đây" type="search">
                                        </div>
                                    </div>
                                    <div style="max-height: 300px; overflow: auto;" class="row g-3">
                                        <?php foreach ($roles as $role) : ?>
                                            <div class="input-group group-role col-sm-6 col-md-6">
                                                <div class="input-group-text">
                                                    <input class="form-check-input data-value" name="roles" <?= in_array($role->id,$userRoleId) ? 'checked' : '' ?> value="<?= $role->id ?>" type="checkbox">
                                                </div>
                                                <label class="form-control list-role"><?= $role->name ?></label>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                    <div class="col-12 gy-6">
                                        <div class="row g-3 justify-content-center">
                                            <div class="col-auto">
                                                <button type="reset" class="btn btn-close-model btn-secondary mx-1" data-bs-dismiss="modal">Huỷ
                                                </button>
                                                <button type="submit" class="btn btn-primary btn-submit mx-1" title="Chỉnh sửa quyền">Chỉnh sửa quyền</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div </div>

                <!-- MODEL-->

                <script src="../inc/scripts/roles.js"></script>
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