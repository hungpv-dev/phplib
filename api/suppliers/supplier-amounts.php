<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];
$res = new Res();

if ($requestMethod == 'GET') {
    $id = getLastStringUri();
    $pagination = new buildPagination2();

    $params = '?page=';
    $search = $_GET['search'] ?? '';
    $show = $_GET['show'] ?? false;

    $page = parameterFromUrl('page') == 0 ? 1 : (int)parameterFromUrl('page');
    $limit = 2;
    $offset = ($page - 1) * $limit;

    $check = checkRole(6);
    if (!$check) {
        $res->exit(403, Responses::getMessage('SUPPLIERS-ERR-03'));
    }
    // Handle

    $model = (new Model('supplier_amounts','s'))->select('s.*, c.code as c_code')->where('supplier_id',$id)->join('currency as c','c.id','s.currency_id');

    if ($search != '') {
        $model = $model->where('name', 'like', '%' . $search . '%');
    }

    $pagination->build($model, $offset, $page, $limit, '/api/suppliers/amounts/'.$id, $params, $_GET['show'] ?? false);
    $res->data = $pagination;
    $res->success();
} else if ($requestMethod == 'PUT') {

    $dataRequest = json_decode(file_get_contents("php://input"), true);

    // Check role
    $check = checkRole(14);

    if (!$check) {
        $res->exit(403, Responses::getMessage('SUPPLIER-AMOUNT-ERR-01'));
    }

    $check = [];
    // Validate
    foreach ($dataRequest as $key => $value) {
        if ($value == '') {
            $check[$key] = $key . ' không được để trống';
        }
    }
    if (!empty($check)) {
        $res->data = $check;
        $res->exit(422, Responses::getMessage('USER-ERR-02'));
    }

    $supplierAmount = (new Model('supplier_amounts'))->create($dataRequest);
    $supplier = (new Model('suppliers'))->find($dataRequest['supplier_id']);
    // // dd($user);
    userActiveLog('thêm tài khoản công nợ ' . $supplier->name . '(#' . $supplier->id . ') - mã công nợ: '.$supplierAmount->id);


    // Response
    $res->success(201, Responses::getMessage('USER-OK-01'));
}
