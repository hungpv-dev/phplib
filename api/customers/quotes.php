<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];
$res = new Res();

$id = getLastStringUri();
if ($requestMethod == 'GET') {
    $pagination = new buildPagination2();

    $params = '?page=';
    $search = $_GET['search'] ?? '';
    $show = $_GET['show'] ?? false;

    $page = parameterFromUrl('page') == 0 ? 1 : (int)parameterFromUrl('page');
    $limit = 2;
    $offset = ($page - 1) * $limit;

    $check = checkRole(21);
    if (!$check) {
        $res->exit(403, Responses::getMessage('QUOTES-ERR-01'));
    }
    // Handle

    $model = (new Model('quotes','q'))->select('q.*,s.name as status_name,u.name as user_name, COALESCE(SUM(qd.quantity), 0) as sum_quantity, COALESCE(SUM(qd.total), 0) as sum_total')
    ->where('q.customer_id',$id)
    ->groupBy('q.id, s.name, u.name')
    ->leftJoin('quote_details qd','qd.quote_id','q.id')
    ->join('quote_status s','s.id','q.status')
    ->join('users u','u.id','q.user_id');

    $pagination->build($model, $offset, $page, $limit, '/api/quotes/'.$id, $params, $_GET['show'] ?? false);
    $pagination->setData(['datetime' => ['created_at'=>'H:i d-m-Y']]);
    $res->data = $pagination;
    $res->success();
} else if ($requestMethod == 'PUT') {

    $dataRequest = json_decode(file_get_contents("php://input"), true);

    $currentDateTime = new DateTime();
    $nowTime = $currentDateTime->format('Y-m-d H:i:s');

    // Check role
    $check = checkRole(23);

    if (!$check) {
        $res->exit(403, Responses::getMessage('QUOTES-ERR-02'));
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
        $res->exit(422, Responses::getMessage('USER-ERR-02'));
    }


    $quote = (new Model('quotes'))->create($dataRequest);

    userActiveLog('thêm báo giá : khách hàng có id - ' . $quote->customer_id . ' - báo giá: (#' . $quote->id . ')');


    // Response
    $res->success(201, Responses::getMessage('QUOTES-OK-01'));
}
