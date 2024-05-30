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

    $check = checkRole(4);
    if (!$check) {
        $res->exit(403, Responses::getMessage('USER-ERR-03'));
    }
    // Handle

    $model = (new Model('users', 'u'))->select('u.*,d.name as d_name')->whereNotIn('u.id', [$_SESSION['authentication']->id])->join('departments as d', 'u.department_id', 'd.id');
    $total = (new Model('users'))->whereNotIn('id', [$_SESSION['authentication']->id]);
    if ($search != '') {
        $model = $model->where('u.name', 'like', '%' . $search . '%');
        $total = $total->where('name', 'like', '%' . $search . '%');
    }

    $total = $total->count();


    if ($show) {
        $users = $model->get();
        $limit = $total;
    } else {
        // Handle
        $users = $model->limit($limit)->offset($offset)->get();
    }
    foreach ($users as $user) {
        $user->created_at = (new DateTime($user->created_at))->format('H:i d-m-Y');
    }
    $pagination->build($users, $total, $page, $limit, '/api/users', $params);
    $res->data = $pagination;
    $res->success();
} else if ($requestMethod == 'PUT') {

    $dataRequest = json_decode(file_get_contents("php://input"), true);

    $currentDateTime = new DateTime();
    $nowTime = $currentDateTime->format('Y-m-d H:i:s');

    $dataRequest['created_at'] = $nowTime;

    // Check role
    $check = checkRole(2);

    if (!$check) {
        $res->exit(403, Responses::getMessage('USER-ERR-01'));
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
            $userEmail = (new Model('users'))->where('email', $value)->first();
            if ($userEmail) {
                $check[$key] = $key . ' đã tồn tại';
            }
        }
    }
    if (!empty($check)) {
        $res->data = $check;
        $res->exit(422, Responses::getMessage('USER-ERR-02'));
    }

    $user = (new Model('users'))->create($dataRequest);

    // dd($user);
    userActiveLog('thêm nhân viên ' . $user->name . '(#' . $user->id . ')');


    // Response
    $res->success(201, Responses::getMessage('USER-OK-01'));
}
