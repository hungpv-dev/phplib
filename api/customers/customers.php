<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];
$res = new Res();

if ($requestMethod == 'GET') {
    $pagination = new buildPagination2();

    $params = '?page=';
    $search = $_GET['search'] ?? '';

    $page = parameterFromUrl('page') == 0 ? 1 : (int)parameterFromUrl('page');
    $limit = 1;
    $offset = ($page - 1) * $limit;

    $check = checkRole(11);
    if (!$check) {
        $res->exit(403, Responses::getMessage('CUSTOMER-ERR-01'));
    }
    // Handle

    $model = (new Model('customers','c'));
    $total = (new Model('customers'));

    if($search != ''){
        $model = $model->where('c.name','like','%'. $search .'%');
        $total = $total->where('name','like','%'. $search .'%');
    }

    $total = $total->count();
    $model = $model->select('c.*,u.name as user_name')->join('users as u','u.id','c.user_id');
    
    $pagination->build($model, $offset, $page, $limit, '/api/customers', $params, $_GET['show'] ?? false);
    $res->data = $pagination;
    $res->success();
} else if ($requestMethod == 'PUT') {

    $dataRequest = json_decode(file_get_contents("php://input"), true);

    $currentDateTime = new DateTime();
    $nowTime = $currentDateTime->format('Y-m-d H:i:s');

    $dataRequest['created_at'] = $nowTime;

    // Check role
    $check = checkRole(12);

    if (!$check) {
        $res->exit(403, Responses::getMessage('CUSTOMER-ERR-02'));
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
            $userEmail = (new Model('customers'))->where('email', $value)->first();
            if ($userEmail) {
                $check[$key] = $key . ' đã tồn tại';
            }
        }
    }
    if (!empty($check)) {
        $res->data = $check;
        $res->exit(422, Responses::getMessage('USER-ERR-02'));
    }


    $customer = (new Model('customers'))->create($dataRequest);

    // dd($user);
    userActiveLog('thêm khách hàng ' . $customer->name . '(#' . $customer->id . ')');


    // Response
    $res->success(201, Responses::getMessage('CUSTOMER-OK-01'));
}
