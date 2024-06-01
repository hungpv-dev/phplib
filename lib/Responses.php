<?php
if (!class_exists('Responses')) {
    class Responses
    {
        const LIST_RESPONSE = array(
            'USER-ERR-01' => 'Bạn không có quyền thêm nhân viên!',
            'USER-ERR-02' => 'Dữ liệu gửi lên không hợp lệ!',
            'USER-ERR-03' => 'Bạn không có quyền xem danh sách nhân viên!',
            'USER-ERR-04' => 'Bạn không có quyền chỉnh sửa nhân viên!',
            'USER-ERR-05' => 'User có quyền cao nhất mới có thể chỉnh sửa quyền nhân viên!',
            'USER-ERR-06' => 'Tài khoản của bạn không có trong hệ thống của chúng tôi!',

            'DEPARTMENT-ERR-01' => 'Bạn không có quyền xem danh sách phòng ban',
            'DEPARTMENT-ERR-02' => 'Bạn không có quyền thêm phòng ban',
            'DEPARTMENT-OK-01' => 'Thêm phòng ban thành công',
            'DEPARTMENT-OK-02' => 'Chỉnh sửa phòng ban thành công',
            'DEPARTMENT-ERR-03' =>  'Bạn không có quyền chỉnh sửa phòng ban',

            'USER-OK-01' => 'Thêm mới nhân sự thành công!',
            'USER-OK-02' => 'Cập nhật thông tin nhân sự thành công!',
            'USER-OK-03' => 'Chỉnh sửa quyền nhân viên thành công!',

            
            'SERVICE-OK-01' => 'Thêm mới thành công',
            'SERVICE-OK-02' => 'Cập nhật thành công',
            
            'QUOTE-OK-01' => 'Thêm mới báo giá thành công!',
            'QUOTE-DETAIL-OK-01' => 'Thêm mới chi tiết báo giá thành công!',
            'QUOTE-DETAIL-OK-02' => 'Xóa chi tiết báo giá thành công!',
            'QUOTE-DETAILS-ERR-04' => 'Bạn không có quyền xóa chi tiết báo giá!',

            'SUPPLIERS-ERR-01' => 'Bạn không có quyền thêm nhà cung cấp!',
            'SUPPLIERS-ERR-02' => 'Dư liệu gửi lên không hợp lệ',
            'SUPPLIERS-ERR-03' => 'Bạn không có quyền xem danh sách nhà cung cấp',
            'SUPPLIERS-ERR-04' => 'Bạn không có quyền cập nhật nhà cung cấp',
            'SUPPLIERS-OK-01' => 'Thêm mới nhà cung cấp thành công!',
            'SUPPLIERS-OK-02' => 'Cập nhật nhà cung cấp thành công!',
            'SUPPLIER-AMOUNT-ERR-01' => 'Bạn không có quyền thêm tài khoản công nợ',

            'CUSTOMER-ERR-01' => 'Bạn không có quyền xem danh sách khách hàng',
            'CUSTOMER-ERR-02' => 'Bạn không có quyền thêm khách hàng',
            'CUSTOMER-ERR-03' => 'Bạn không có chỉnh sửa khách hàng',
            'CUSTOMER-OK-01' => 'Thêm khách hàng thành công',
            'CUSTOMER-OK-02' => 'Cập nhật khách hàng thành công',

            'QUOTES-ERR-01' => 'Bạn khong có quyền xem báo giá',
            'QUOTES-ERR-02' => 'Bạn không có quyền thêm báo giá',
            'QUOTES-ERR-03' => 'Bạn không có quyền sửa báo giá',
            'QUOTES-OK-01' => 'Thêm báo giá thành công',
            'QUOTES-OK-02' => 'Sửa báo giá thành công',
            'QUOTES-OK-03' => 'Thêm chi tiết báo giá thành công',
            
            'VATTU-ERR-01' => 'Bạn không có quyền xem danh sách vật tư',
            'VATTU-ERR-02' => 'Bạn không có quyền thêm vật tư',
            'VATTU-ERR-03' => 'Bạn không có quyền sửa vật tư',
            'VATTU-OK-01' => 'Thêm vật tư thành công',
            'VATTU-OK-02' => 'Cập nhật vật tư thành công',
            'LVT-ERR-01' => 'Bạn không có quyền xem danh sách loại vật tư',
            'LVT-ERR-02' => 'Bạn không có quyền sửa loại vật tư',
            'LVT-ERR-03' => 'Bạn không có quyền thêm loại vật tư',
            'LVT-OK-01' => 'Thêm loại vật tư thành công',
            'LVT-OK-02' => 'Sửa loại vật tư thành công',
            
            'UNIT-ERR-01' => 'Bạn không có quyền xem danh sách đơn vị tính',
            'UNIT-ERR-02' => 'Bạn không có quyền sửa đơn vị tính',
            'UNIT-ERR-03' => 'Bạn không có quyền thêm đơn vị tính',
            'UNIT-OK-01' => 'Thêm đơn vị tính thành công',
            'UNIT-OK-02' => 'Sửa đơn vị tính thành công',

            'PRODUCTS-ERR-01' => 'Bạn không có quyền xem danh sách sản phẩm hoặc dịch vụ',
            'PRODUCTS-ERR-02' => 'Bạn không có quyền thêm sản phẩm hoặc dịch vụ',
            'PRODUCTS-ERR-03' => 'Bạn không có quyền sửa sản phẩm hoặc dịch vụ',
            'PRODUCTS-OK-01' => 'Thêm mới thành công',
            'PRODUCTS-OK-02' => 'Cập nhật thành công',


            'CREATE-OK-01' => 'Thực hiện thêm thành công!',
            'CREATE-ERR-01' => 'Thêm thất bại!',
            'UPDATE-OK-01' => 'Lưu thành công!',
            'UPDATE-ERR-01' => 'Lưu không thành công!',

            'ERROR-EMPTY' => 'Vui lòng nhập đầy đủ thông tin cần thiết!'

        );
        public static function getMessage($code): string
        {
            return isset(self::LIST_RESPONSE[$code]) ? self::LIST_RESPONSE[$code] : "";
        }
    }
}
