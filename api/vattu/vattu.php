<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];
$res = new Res();

if ($requestMethod == 'GET') {
    $pagination = new buildPagination2();

    $params = '?page=';
    $search = $_GET['search'] ?? '';
    $show = $_GET['show'] ?? false;

    $page = parameterFromUrl('page') == 0 ? 1 : (int)parameterFromUrl('page');
    $limit = 2;
    $offset = ($page - 1) * $limit;

    $check = checkRole(15);
    if (!$check) {
        $res->exit(403, Responses::getMessage('VATTU-ERR-01'));
    }
    // Handle

    
    $model = (new Model('vat_tu','v'))->select('v.*,u.name as unit_name')->join('units u','u.id','v.unit_id');

    if ($search != '') {
        $model = $model->where('v.name', 'like', '%' . $search . '%');
    }

    $pagination->build($model, $offset, $page, $limit, '/api/vattu', $params, $_GET['show'] ?? false);
    $pagination->setData(['datetime' => ['created_at' => 'H:i d-m-Y']]);
    $res->data = $pagination;
    $res->success();
} else if ($requestMethod == 'PUT') {

    $dataRequest = json_decode(file_get_contents("php://input"), true);

    $currentDateTime = new DateTime();
    $nowTime = $currentDateTime->format('Y-m-d H:i:s');

    $dataRequest['created_at'] = $nowTime;

    // Check role
    $check = checkRole(16);

    if (!$check) {
        $res->exit(403, Responses::getMessage('VATTU-ERR-02'));
    }

    $check = [];
    // Validate
    foreach ($dataRequest as $key => $value) {
        if ($value == '' && $key != 'description') {
            $check[$key] = $key . ' không được để trống';
        }
    }
    if (!empty($check)) {
        $res->data = $check;
        $res->exit(422, Responses::getMessage('USER-ERR-02'));
    }


    $vattu = (new Model('vat_tu'))->create($dataRequest);

    // dd($user);
    userActiveLog('thêm vật tư ' . $vattu->name . '(#' . $vattu->id . ')');


    // Response
    $res->success(201, Responses::getMessage('VATTU-OK-01'));
}
