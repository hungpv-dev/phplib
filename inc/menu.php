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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
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

                    <!--START--Nhân viên--START-->
                    <div class="nav-item-wrapper"><a class="nav-link label-1  <?php if (preg_match('#^/quan-ly-san-pham-dich-vu#iu', $uri)) echo 'active'; ?>" href="/quan-ly-san-pham-dich-vu" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar me-2" style="stroke-width:2.5;">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <span class="nav-link-text-wrapper"><span class="nav-link-text">Quản lý sản phẩm & dịch vụ</span></span>
                            </div>
                        </a>
                    </div>
                    <!--END--Nhân viên--END-->

                    <!--START--Vật tư--START-->
                    <div class="nav-item-wrapper"><a class="nav-link label-1  <?php if (preg_match('#^/quan-ly-vat-tu#iu', $uri)) echo 'active'; ?>" href="/quan-ly-vat-tu" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tool">
                                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                                    </svg></span>
                                <span class="nav-link-text-wrapper"><span class="nav-link-text">Quản lý vật tư</span></span>
                            </div>
                        </a>
                    </div>
                    <!--END--Vật tư--END-->

                    <!--START--Loại vật tư--START-->
                    <div class="nav-item-wrapper"><a class="nav-link label-1  <?php if (preg_match('#^/quan-ly-loai-vat-tu#iu', $uri)) echo 'active'; ?>" href="/quan-ly-loai-vat-tu" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders text-body fs-5">
                                        <line x1="4" y1="21" x2="4" y2="14"></line>
                                        <line x1="4" y1="10" x2="4" y2="3"></line>
                                        <line x1="12" y1="21" x2="12" y2="12"></line>
                                        <line x1="12" y1="8" x2="12" y2="3"></line>
                                        <line x1="20" y1="21" x2="20" y2="16"></line>
                                        <line x1="20" y1="12" x2="20" y2="3"></line>
                                        <line x1="1" y1="14" x2="7" y2="14"></line>
                                        <line x1="9" y1="8" x2="15" y2="8"></line>
                                        <line x1="17" y1="16" x2="23" y2="16"></line>
                                    </svg>
                                </span>
                                <span class="nav-link-text-wrapper"><span class="nav-link-text">Quản lý loại vật tư</span></span>
                            </div>
                        </a>
                    </div>
                    <!--END--Loại--END-->
                    <!--START--Loại vật tư--START-->
                    <div class="nav-item-wrapper"><a class="nav-link label-1  <?php if (preg_match('#^/quan-ly-don-vi-tinh-tu#iu', $uri)) echo 'active'; ?>" href="/quan-ly-don-vi-tinh" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minimize-2 text-body fs-5">
                                        <polyline points="4 14 10 14 10 20"></polyline>
                                        <polyline points="20 10 14 10 14 4"></polyline>
                                        <line x1="14" y1="10" x2="21" y2="3"></line>
                                        <line x1="3" y1="21" x2="10" y2="14"></line>
                                    </svg>
                                </span>
                                <span class="nav-link-text-wrapper"><span class="nav-link-text">Quản lý đơn vị tính</span></span>
                            </div>
                        </a>
                    </div>
                    <!--END--Loại--END-->
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