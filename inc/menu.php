<?php
$uri = $_SERVER['REQUEST_URI'];
// xoá bỏ đoạn đằng sau dấu ?
$uri = preg_replace('/\?.*/', '', $uri);
?>
<nav class="navbar navbar-vertical navbar-expand-lg">
    <script>
        var navbarStyle = window.config.config.phoenixNavbarStyle;
        if (navbarStyle && navbarStyle !== 'transparent') {
            document.querySelector('body').classList.add(`navbar-${navbarStyle}`);
        }
    </script>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <!-- scrollbar removed-->
        <div class="navbar-vertical-content">
            <ul class="navbar-nav flex-column" id="navbarVerticalNav">

                <li class="nav-item">
                    <!-- parent pages-->
                    <div class="nav-item-wrapper"><a class="nav-link label-1" href="/" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="uil-university fs-8"></span></span><span class="nav-link-text-wrapper"><span class="nav-link-text">Trang chủ</span></span>
                            </div>
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <!-- label-->
                    <p class="navbar-vertical-label">Quản Lý</p>
                    <hr class="navbar-vertical-line" />
                    <!-- parent pages-->

                    <!--START--Phòng ban--START-->
                    <div class="nav-item-wrapper"><a class="nav-link label-1  <?php if (preg_match('#^/quan-ly-phong-ban#iu', $uri)) echo 'active'; ?>" href="/quan-ly-phong-ban" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Quản lý Phòng ban</span>
                                </span>
                            </div>
                            
                        </a>
                    </div>
                    <!--END--Phòng ban--END-->

                    <!--START--Nhân viên--START-->
                    <div class="nav-item-wrapper"><a class="nav-link label-1  <?php if (preg_match('#^/quan-ly-nhan-vien#iu', $uri)) echo 'active'; ?>" href="/quan-ly-nhan-vien" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="uil-apps fs-8"></span></span><span class="nav-link-text-wrapper"><span class="nav-link-text">Quản lý nhân viên</span></span>
                            </div>
                        </a>
                    </div>
                    <!--END--Nhân viên--END-->


                    <!--START--Nhân viên--START-->
                    <div class="nav-item-wrapper"><a class="nav-link label-1  <?php if (preg_match('#^/quan-ly-nha-cung-cap#iu', $uri)) echo 'active'; ?>" href="/quan-ly-nha-cung-cap" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="uil-apps fs-8"></span></span><span class="nav-link-text-wrapper"><span class="nav-link-text">Quản lý nhà cung cấp</span></span>
                            </div>
                        </a>
                    </div>
                    <!--END--Nhân viên--END-->

                    
                    <!--START--Nhân viên--START-->
                    <div class="nav-item-wrapper"><a class="nav-link label-1  <?php if (preg_match('#^/quan-ly-khach-hang#iu', $uri)) echo 'active'; ?>" href="/quan-ly-khach-hang" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="uil-apps fs-8"></span></span><span class="nav-link-text-wrapper"><span class="nav-link-text">Quản lý khách hàng</span></span>
                            </div>
                        </a>
                    </div>
                    <!--END--Nhân viên--END-->
                </li>
            </ul>
        </div>
    </div>
    <div class="navbar-vertical-footer">
        <button class="btn navbar-vertical-toggle border-0 fw-semibold w-100 white-space-nowrap d-flex align-items-center">
            <span class="uil uil-left-arrow-to-left fs-8"></span>
            <span class="uil uil-arrow-from-right fs-8"></span>
            <span class="navbar-vertical-footer-text ms-2">Thu gọn</span></button>
    </div>
</nav>