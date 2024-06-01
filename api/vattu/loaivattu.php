<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];
$res = new Res();

if ($requestMethod == 'GET') {
    $pagination = new buildPagination2();

    $params = '?page=';
    $search = $_GET['search'] ?? '';
    $show = $_GET['show'] ?? false;

    $page = parameterFromUrl('page') == 0 ? 1 : (int)parameterFromUrl('page');
    $limit = 3;
    $offset = ($page - 1) * $limit;

    $check = checkRole(25);
    if (!$check) {
        $res->exit(403, Responses::getMessage('LVT-ERR-01'));
    }
    // Handle

    $model = (new Model('loai_vat_tu'));
    
    if ($search != '') {
        $model = $model->where('name', 'like', '%' . $search . '%');
    }

    $pagination->build($model, $offset, $page, $limit, '/api/loaivattu', $params, $_GET['show'] ?? false);
    $res->data = $pagination;
    $res->success();
} else if ($requestMethod == 'PUT') {

    $dataRequest = json_decode(file_get_contents("php://input"), true);
    
    $check = checkRole(27);

    if (!$check) {
        $res->exit(403, Responses::getMessage('LVT-ERR-03'));
    }

    $check = [];
    // Validate
    foreach ($dataRequest as $key => $value) {
        if ($value == '') {
            $check[$key] = $key . ' không được để trống';
        }

        if ($key == 'name') {
            $vattu = (new Model('loai_vat_tu'))->where('name', $value)->first();
            if ($vattu) {
                $check[$key] = $key . ' đã tồn tại';
            }
        }
    }
    if (!empty($check)) {
        $res->data = $check;
        $res->exit(422, Responses::getMessage('USER-ERR-02'));
    }


    $vattu = (new Model('loai_vat_tu'))->create($dataRequest);

    // dd($user);
    userActiveLog('thêm vật tư ' . $vattu->name . '(#' . $vattu->id . ')');


    // Response
    $res->success(201, Responses::getMessage('LVT-OK-01'));
}
