<footer class="footer position-absolute">
    <div class="row g-0 justify-content-between align-items-center h-100">
        <div class="col-12 col-sm-auto text-center">
            <p class="mb-0 mt-2 mt-sm-0 text-body">Sản phẩm được phát triển bởi<a class="mx-1" href="https://asfy.vn">ASFY.,JSC</a>
                <span class="d-none d-sm-inline-block"></span><span class="d-none d-sm-inline-block mx-1">|</span><br class="d-sm-none" /> &copy; <?php echo date("Y") ?>
            </p>
        </div>
    </div>
</footer>

<div class="modal fade" id="modalSuccessNotification" tabindex="-1" aria-labelledby="modalSuccessNotificationLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border border-translucent shadow-lg">
            <div>
                <div class="modal-header px-card border-0">
                    <div class="w-100 d-flex justify-content-center align-items-start">
                        <div>
                            <p class="mb-0 fs-7 lh-sm text-success success-message text-center"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center border-0">
                    <button class="btn btn-secondary text-center px-3" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fs-8">Đóng</span></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalErrorNotification" tabindex="-1" aria-labelledby="modalSuccessNotificationLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border border-translucent shadow-lg">
            <div>
                <div class="modal-header px-card border-0">
                    <div class="w-100 d-flex justify-content-center align-items-start">
                        <div>
                            <p class="mb-0 fs-7 lh-sm text-danger error-message text-center"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center border-0">
                    <button class="btn btn-secondary text-center px-3" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fs-8">Đóng</span></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalConfirmDelete" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border border-translucent">
            <div>
                <div class="modal-header px-card border-0">
                    <div class="w-100 d-flex justify-content-center align-items-start">
                        <div>
                            <h5 class="mb-0 lh-sm text-body-highlight confirm-message"></h5>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center border-0">
                    <button class="btn btn-danger px-4 btn-confirm" title="Xoá">Xoá</button>
                    <button class="btn btn-secondary pe-4" type="button" data-bs-dismiss="modal" aria-label="Close" >Huỷ</button>
                </div>
            </div>
        </div>
    </div>
</div>