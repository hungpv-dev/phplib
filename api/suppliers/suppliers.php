<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];
$res = new Res();

if ($requestMethod == 'GET') {
    $pagination = new buildPagination();

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

    $model = (new Model('suppliers'));
    $total = (new Model('suppliers'));
    if ($search != '') {
        $model = $model->where('name', 'like', '%' . $search . '%');
        $total = $total->where('name', 'like', '%' . $search . '%');
    }

    $total = $total->count();

    if ($show) {
        $suppliers = $model->get();
        $limit = $total;
    } else {
        $suppliers = $model->limit($limit)->offset($offset)->get();
    }

    foreach ($suppliers as $supplier) {
        $supplier->created_at = (new DateTime($supplier->created_at))->format('H:i d-m-Y');
    }
    $pagination->build($suppliers, $total, $page, $limit, '/api/suppliers', $params);
    $res->data = $pagination;
    $res->success();
} else if ($requestMethod == 'PUT') {

    $dataRequest = json_decode(file_get_contents("php://input"), true);

    $currentDateTime = new DateTime();
    $nowTime = $currentDateTime->format('Y-m-d H:i:s');

    $dataRequest['created_at'] = $nowTime;

    // Check role
    $check = checkRole(5);
    if (!$check) {
        $res->exit(403, Responses::getMessage('SUPPLIERS-ERR-01'));
    }

    $check = [];
    // Validate
    foreach ($dataRequest as $key => $value) {
        if ($value == '') {
            $check[$key] = $key . ' không được để trống';
        }

        if ($key == 'email') {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $check[$key] = $key . ' không hợp lệ';
            }
        }
    }
    if (!empty($check)) {
        $res->data = $check;
        $res->exit(422, Responses::getMessage('SUPPLIERS-ERR-02'));
    }

    $suppliers = (new Model('suppliers'))->create($dataRequest);

    userActiveLog('thêm nhà cung cấp ' . $suppliers->name . '(#' . $suppliers->id . ')');


    // Response
    $res->success(201, Responses::getMessage('SUPPLIERS-OK-01'));
}
