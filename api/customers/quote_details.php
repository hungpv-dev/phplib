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

    $model = (new Model('quote_details','q'))
    ->select('q.*,p.name as product_name,u.name as unit_name')->where('quote_id',$id)
    ->join('units u','u.id','q.unit_id')
    ->join('products p','p.id','q.product_id');

    if ($search != '') {
        $model = $model->where('p.name', 'like', '%' . $search . '%');
    }

    $pagination->build($model, $offset, $page, $limit, '/api/quote_details/'.$id, $params, $_GET['show'] ?? false);
    $res->data = $pagination;
    $res->success();
} else if ($requestMethod == 'PUT') {

    $dataRequest = json_decode(file_get_contents("php://input"), true);

    $currentDateTime = new DateTime();
    $nowTime = $currentDateTime->format('Y-m-d H:i:s');


    // Check role
    $check = checkRole(23);

    if (!$check) {
        $res->exit(403, Responses::getMessage('USER-ERR-01'));
    }

    $check = [];
    // Validate
    foreach ($dataRequest as $key => $value) {
        if ($value == '' && $key != 'note') {
            $check[$key] = $key . ' không được để trống';
        }
    }

    if (!empty($check)) {
        $res->data = $check;
        $res->exit(422, Responses::getMessage('USER-ERR-02'));
    }


    $quote_detail = (new Model('quote_details'))->create($dataRequest);

    // dd($user);
    userActiveLog('thêm báo giá chi tiết: sản phẩm ' . $quote_detail->product_id . ' id báo giá: (#' . $quote_detail->id . ')');


    // Response
    $res->success(201, Responses::getMessage('QUOTES-OK-03'));
}
