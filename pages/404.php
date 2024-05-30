<!DOCTYPE html>
<html data-navigation-type="default" data-navbar-horizontal-shape="default" lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Không tìm thấy trang</title>

    <?php include 'inc/favicons.php'?>

    <!--    Stylesheets-->
    <?php include 'inc/css.php'?>
</head>


<body>

<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main" id="top">
    <div class="px-3">
        <div class="row min-vh-100 flex-center p-5">
            <div class="col-12 col-xl-10 col-xxl-8">
                <div class="row justify-content-center align-items-center g-5">
                    <div class="col-12 col-lg-6 text-center order-lg-1"><img class="img-fluid w-lg-100 d-dark-none" src="../../assets/img/spot-illustrations/404-illustration.png" alt="" width="400" /><img class="img-fluid w-md-50 w-lg-100 d-light-none" src="../../assets/img/spot-illustrations/dark_404-illustration.png" alt="" width="540" /></div>
                    <div class="col-12 col-lg-6 text-center text-lg-start"><img class="img-fluid mb-6 w-50 w-lg-75 d-dark-none" src="../../assets/img/spot-illustrations/404.png" alt="" /><img class="img-fluid mb-6 w-50 w-lg-75 d-light-none" src="../../assets/img/spot-illustrations/dark_404.png" alt="" />
                        <h2 class="text-body-secondary fw-bolder mb-3">Không tìm thấy trang!</h2>
                        <p class="text-body mb-5">Rất tiếc, không tìm thấy trang bạn yêu cầu. </p><a class="btn btn-lg btn-primary" href="/">Về Trang Chủ</a>
                    </div>
                </div>
            </div>
        </div>
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
</main>
<!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->
<!--    JavaScripts-->
<?php include 'inc/js.php'?>
</body>

</html>