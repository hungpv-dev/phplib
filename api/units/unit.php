<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];
$res = new Res();

$id = getLastStringUri();
if ($requestMethod == 'GET') {

    $check = checkRole(28);
    if (!$check) {
        $res->exit(403, Responses::getMessage('UNIT-ERR-01'));
    }
    // Handle
    $unit = (new Model('units'))->find($id);

    $res->data = $unit;
    $res->success();
} else if ($requestMethod == 'PUT') {

    $dataRequest = json_decode(file_get_contents("php://input"), true);

    // Check role
    $check = checkRole(29);

    if (!$check) {
        $res->exit(403, Responses::getMessage('UNIT-ERR-02'));
    }

    $check = [];
    // Validate
    foreach ($dataRequest as $key => $value) {
        if ($value == '') {
            $check[$key] = $key . ' không được để trống';
        }

        if ($key == 'name') {
            $vattu = (new Model('units'))->where('name', $value)->first();
            if ($vattu) {
                $check[$key] = $key . ' đã tồn tại';
            }
        }
    }
    if (!empty($check)) {
        $res->data = $check;
        $res->exit(422, Responses::getMessage('USER-ERR-02'));
    }


    $unit = (new Model('units'))->update($id, $dataRequest);

    userActiveLog('sửa đơn vị tính ' . $unit->name . '(#' . $unit->id . ')');

    // Response
    $res->success(200, Responses::getMessage('UNIT-OK-02'));
}
