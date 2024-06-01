<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];
$res = new Res();

$id = getLastStringUri();
if ($requestMethod == 'GET') {

    $check = checkRole(21);
    if (!$check) {
        $res->exit(403, Responses::getMessage('QUOTES-ERR-01'));
    }
    // Handle
    $quote = (new Model('quotes', 'q'))
    ->select('q.*,s.name as status_name,u.name as user_name')
    ->where('q.id', $id)
        ->join('quote_status s', 's.id', 'q.status')
        ->join('users u', 'u.id', 'q.user_id')->first();

    $res->data = $quote;
    $res->success();
} else if ($requestMethod == 'PUT') {

    $dataRequest = json_decode(file_get_contents("php://input"), true);

    $currentDateTime = new DateTime();
    $nowTime = $currentDateTime->format('Y-m-d H:i:s');


    // Check role
    $check = checkRole(22);

    if (!$check) {
        $res->exit(403, Responses::getMessage('QUOTES-ERR-03'));
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

    $quote = (new Model('quotes'))->update($id,$dataRequest);

    userActiveLog('sửa báo giá : khách hàng có id - ' . $quote->customer_id . ' - báo giá: (#' . $quote->id . ')');

    // Response
    $res->success(200, Responses::getMessage('QUOTES-OK-02'));
}
