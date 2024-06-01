<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];
$res = new Res();

$id = getLastStringUri();
if ($requestMethod == 'GET') {

    $check = checkRole(25);
    if (!$check) {
        $res->exit(403, Responses::getMessage('LVT-ERR-01'));
    }
    // Handle
    $lvt = (new Model('loai_vat_tu'))->find($id);

    $res->data = $lvt;
    $res->success();
} else if ($requestMethod == 'PUT') {

    $dataRequest = json_decode(file_get_contents("php://input"), true);

    // Check role
    $check = checkRole(26);

    if (!$check) {
        $res->exit(403, Responses::getMessage('LVT-ERR-02'));
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


    $lvt = (new Model('loai_vat_tu'))->update($id, $dataRequest);

    userActiveLog('sửa vật tư ' . $lvt->name . '(#' . $lvt->id . ')');

    // Response
    $res->success(200, Responses::getMessage('LVT-OK-02'));
}
