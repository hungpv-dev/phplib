<?php
$requestMethod = $_SERVER['REQUEST_METHOD'];
$res = new Res();

if ($requestMethod == 'GET') {
    $pagination = new buildPagination2();

    $params = '?page=';
    $search = $_GET['search'] ?? '';
    $show = $_GET['show'] ?? false;

    $page = parameterFromUrl('page') == 0 ? 1 : (int)parameterFromUrl('page');
    $limit = 1;
    $offset = ($page - 1) * $limit;

    $check = checkRole(18);
    if (!$check) {
        $res->exit(403, Responses::getMessage('PRODUCTS-ERR-01'));
    }
    // Handle

    $model = (new Model('products','p'))
    ->select("p.*,c.name as c_name,u.name as u_name")
    ->join('categories c','c.id','p.category_id')
    ->join('units u','u.id','p.unit_id');
  
    if ($search != '') {
        $model = $model->where('p.name', 'like', '%' . $search . '%');
    }


    
    if(isset($_GET['filter'])){
        $filter = $_GET['filter'];
        if($filter == 2){
            $model = $model->where('p.category_id', 2);
        }else{
            $model = $model->where('p.category_id','!=', 2);
        }
    }


    $pagination->build($model, $offset, $page, $limit, '/api/products', $params, $_GET['show'] ?? false);
    $pagination->setData(['datetime' => ['created_at' => 'H:i d-m-Y','updated_at' => 'H:i d-m-Y']]);
    $res->data = $pagination;
    $res->success();
} else if ($requestMethod == 'PUT') {

    $dataRequest = json_decode(file_get_contents("php://input"), true);

    $currentDateTime = new DateTime();
    $nowTime = $currentDateTime->format('Y-m-d H:i:s');

    $dataRequest['created_at'] = $nowTime;

    // Check role
    $check = checkRole(19);

    if (!$check) {
        $res->exit(403, Responses::getMessage('PRODUCTS-ERR-02'));
    }

    $check = [];
    // Validate
    foreach ($dataRequest as $key => $value) {
        if ($value == '' && $key != 'desc') {
            $check[$key] = $key . ' không được để trống';
        }
    }
    if (!empty($check)) {
        $res->data = $check;
        $res->exit(422, Responses::getMessage('USER-ERR-02'));
    }


    $res->data = $dataRequest;
    $products = (new Model('products'))->create($dataRequest);

    userActiveLog('thêm dịch vụ sản phẩm ' . $products->name . '(#' . $products->id . ')');


    // Response
    $res->success(201, Responses::getMessage('PRODUCTS-OK-01'));
}
