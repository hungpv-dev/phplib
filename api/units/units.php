<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];
$res = new Res();

if ($requestMethod == 'GET') {
    $pagination = new buildPagination2();

    $params = '?page=';
    $search = $_GET['search'] ?? '';
    $filter = $_GET['filter'] ?? '';
    $show = $_GET['show'] ?? false;

    $page = parameterFromUrl('page') == 0 ? 1 : (int)parameterFromUrl('page');
    $limit = 3;
    $offset = ($page - 1) * $limit;

    $check = checkRole(28);
    if (!$check) {
        $res->exit(403, Responses::getMessage('UNIT-ERR-01'));
    }
    // Handle


    $model = (new Model('units'));
    
    if ($search != '') {
        $model = $model->where('name', 'like', '%' . $search . '%');
    }
    
    if($filter != ''){
        $model = $model->where('type',$filter);
    }

    $pagination->build($model, $offset, $page, $limit, '/api/units', $params, $_GET['show'] ?? false);
    $res->data = $pagination;
    $res->success();
} else if ($requestMethod == 'PUT') {

    $dataRequest = json_decode(file_get_contents("php://input"), true);
    
    $check = checkRole(30);

    if (!$check) {
        $res->exit(403, Responses::getMessage('UNIT-ERR-03'));
    }

    $check = [];
    // Validate
    foreach ($dataRequest as $key => $value) {
        if ($value == '') {
            $check[$key] = $key . ' không được để trống';
        }

        if ($key == 'name') {
            $unit = (new Model('units'))->where('name', $value)->first();
            if ($unit) {
                $check[$key] = $key . ' đã tồn tại';
            }
        }
    }
    if (!empty($check)) {
        $res->data = $check;
        $res->exit(422, Responses::getMessage('USER-ERR-02'));
    }


    $unit = (new Model('units'))->create($dataRequest);

    // dd($user);
    userActiveLog('thêm đơn vị tính ' . $unit->name . '(#' . $unit->id . ')');


    // Response
    $res->success(201, Responses::getMessage('UNIT-OK-01'));
}
