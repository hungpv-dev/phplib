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

    $check = checkRole(8);
    if (!$check) {
        $res->exit(403, Responses::getMessage('DEPARTMENT-ERR-01'));
    }

    // Handle

    $model = (new Model('departments','d'))->select("d.*, COALESCE(COUNT(u.id), 0) as total_user")->leftJoin('users u','d.id','u.department_id')->groupBy('d.id');
    $total = (new Model('departments'));
    if($search){
        $model = $model->where('d.name','like','%'.$search.'%');
        $total = $total->where('name','like','%'.$search.'%');
    }
    $departments = $model->get();
    $total = $total->count();

    if ($show) {
        $departments = $model->get();
        $limit = $total;
    } else {
        // Handle
        $departments = $model->limit($limit)->offset($offset)->get();
    }
    
    $pagination->build($departments, $total, $page, $limit, '/api/departments', $params);
    $res->data = $pagination;
    $res->success();
} else if ($requestMethod == 'PUT') {

    $dataRequest = json_decode(file_get_contents("php://input"), true);

    // Check role
    $check = checkRole(9);

    if (!$check) {
        $res->exit(403, Responses::getMessage('DEPARTMENT-ERR-02'));
    }

    $check = [];
    // Validate
    foreach ($dataRequest as $key => $value) {
        if ($value == '') {
            $check[$key] = $key . ' không được để trống';
        }
        if($key == 'name'){
            $department = (new Model('departments'))->where('name',$value)->first();
            if($department){
                $check[$key] = $key . ' đã tồn tại';
            }
        }
    }
    if (!empty($check)) {
        $res->data = $check;
        $res->exit(422, Responses::getMessage('DEPARTMENTS-ERR-01'));
    }


    $department = (new Model('departments'))->create($dataRequest);

    // // dd($user);
    userActiveLog('thêm phòng ban ' . $department->name . '(#' . $department->id . ')');


    // Response
    $res->success(201, Responses::getMessage('DEPARTMENT-OK-01'));
}
