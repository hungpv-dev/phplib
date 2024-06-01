<?php
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $res = new Res();

    $id = getLastStringUri();
    if($requestMethod == 'GET'){

        $check = checkRole(18);
        if(!$check){
            $res->exit(403,Responses::getMessage('PRODUCTS-ERR-01'));
        }

        $products = (new Model('products'))->find($id);
        
        $res->data = $products;
        $res->success();
    }else if($requestMethod == 'PUT'){

        $dataRequest = json_decode(file_get_contents("php://input"), true);
        
        $currentDateTime = new DateTime();
        $nowTime = $currentDateTime->format('Y-m-d H:i:s');


        // Check role
        $check = checkRole(20);

        if(!$check){
            $res->exit(403,Responses::getMessage('PRODUCTS-ERR-03'));
        }

        $check = [];
        // Validate
        foreach($dataRequest as $key => $value){
            if($value == ''){
                $check[$key] = $key .' không được để trống';
            }

            if($key == 'email'){
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $check[$key] = $key .' không hợp lệ';
                }
                $userEmail = (new Model('users'))->where('email',$value)->first();
                if($userEmail){
                    $check[$key] = $key .' đã tồn tại trong hệ thống';
                }
            }
        }
        if(!empty($check)){
            $res->data = $check;
            $res->exit(422,Responses::getMessage('USER-ERR-02'));
        }
        

        $product = (new Model('products'))->update($id,$dataRequest);

        userActiveLog('sửa nhân viên '.$product->name.'(#'.$product->id.')');

        // Response
        $res->success(200, Responses::getMessage('PRODUCTS-OK-02'));
    }
    

?>