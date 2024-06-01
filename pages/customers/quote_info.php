<?php
$id = getLastStringUri();
$quote = (new Model('quotes','q'))
->select('q.*, COALESCE(SUM(qd.quantity), 0) as sum_qd, COALESCE(SUM(qd.total), 0) as total_qd')
->join('quote_details qd','qd.quote_id','q.id')
->groupBy('qd.quote_id')
->where('q.id',$id)->first();
if (!$quote) {
    redirect('/quan-ly-khach-hang');
}
$quoteDetails = (new Model('quote_details', 'q'))
    ->select('q.*, p.name as product_name, u.name as unit_name')
    ->join('products p', 'p.id', 'q.product_id')
    ->join('units u', 'u.id', 'q.unit_id')
    ->where('q.quote_id', $quote->id)->get();

?>
<!DOCTYPE html>
<html data-navigation-type="default" data-navbar-horizontal-shape="default" lang="en-US" dir="ltr" xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--    Tiêu đề-->
    <title>Thông tin báo giá</title>

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
                    <li class="breadcrumb-item"><a href="/quan-ly-bao-gia/<?= $quote->customer_id ?>">Quản lý báo giá </a></li>
                    <li class="breadcrumb-item">Thông tin báo giá</li>
                </ol>
            </nav>
            <h2 class="text-bold text-body-emphasis mb-5">Thông tin báo giá</h2>
            <div>
                <div class="bg-body dark__bg-gray-1100 p-4 mb-4 rounded-2">
                    <div class="row g-4">
                        <div class="col-12 col-lg-3">
                            <div class="row g-4 g-lg-2">
                                <div class="col-12 col-sm-6 col-lg-12">
                                    <div class="row align-items-center g-0">
                                        <div class="col-auto col-lg-8 col-xl-6">
                                            <h6 class="mb-0 me-3">Số lượng sản phẩm:</h6>
                                        </div>
                                        <div class="col-auto col-lg-4 col-xl-6">
                                            <p class="fs-9 text-body-secondary fw-semibold mb-0"><?= $quote->sum_qd ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-12">
                                    <div class="row align-items-center g-0">
                                        <div class="col-auto col-lg-6 col-xl-6">
                                            <h6 class="me-3">Thành tiền:</h6>
                                        </div>
                                        <div class="col-auto col-lg-6 col-xl-6">
                                            <p class="fs-9 text-body-secondary fw-semibold mb-0"><?= number_format($quote->total_qd) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-5">
                            <div class="row g-4 gy-lg-5">
                                <div class="col-12 col-lg-8">
                                    <h6 class="mb-2 me-3">Địa chỉ nhận hàng:</h6>
                                    <p class="fs-9 text-body-secondary fw-semibold mb-0"><?= $quote->consignee_address ?></p>
                                </div>

                                <div class="col-12 col-lg-4">
                                    <h6 class="mb-2">Trạng thái:</h6>
                                    <p class="fs-9 text-body-secondary fw-semibold mb-0"><?= $quote->status ?></p>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <h6 class="mb-2">Tên người nhận:</h6>
                                    <p class="fs-9 text-body-secondary fw-semibold mb-0"><?= $quote->consignee_name ?></p>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <h6 class="mb-2">Số điện thoại:</h6>
                                    <p class="fs-9 text-body-secondary fw-semibold mb-0"><?= $quote->consignee_phone ?></p>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <h6 class="mb-2">Ngày tạo:</h6>
                                    <p class="fs-9 text-body-secondary fw-semibold mb-0"><?= (new DateTime($quote->created_at))->format('H:i d-m-Y') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Table -->
                <h5>Danh sách sản phẩm và dịch vụ</h5>
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
                                </tr>
                            </thead>

                            <tbody class="list-data" id="data_table_body">
                                <?php foreach ($quoteDetails as $i => $qd) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i + 1 ?></td>
                                        <td class="text-center"><?= $qd->product_name ?></td>
                                        <td class="text-center"><?= $qd->quantity ?></td>
                                        <td class="text-center"><?= $qd->unit_name ?></td>
                                        <td class="text-center"><?= number_format($qd->price) ?></td>
                                        <td class="text-center"><?= number_format($qd->total) ?></td>
                                        <td class="text-center"><?= $qd->note == '' ? 'Không' : $qd->note ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="paginations"></div>
                </div>
            </div>

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