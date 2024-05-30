<?php
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $res = new Res();

    $id = getLastStringUri();
    if($requestMethod == 'GET'){

        $check = checkRole(11);
        if(!$check){
            $res->exit(403,Responses::getMessage('CUSTOMER-ERR-01'));
        }
        // Handle
        $customer = (new Model('customers','c'))->select('c.*,u.name as user_name')->join('users as u','u.id','c.user_id')->where('c.id',$id)->first();
        
        $res->data = $customer;
        $res->success();
    }else if($requestMethod == 'PUT'){

        $dataRequest = json_decode(file_get_contents("php://input"), true);
        
        $currentDateTime = new DateTime();
        $nowTime = $currentDateTime->format('Y-m-d H:i:s');


        // Check role
        $check = checkRole(13);

        if(!$check){
            $res->exit(403,Responses::getMessage('CUSTOMER-ERR-03'));
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
                $userEmail = (new Model('customers'))->where('email',$value)->first();
                if($userEmail){
                    $check[$key] = $key .' đã tồn tại trong hệ thống';
                }
            }
        }
        if(!empty($check)){
            $res->data = $check;
            $res->exit(422,Responses::getMessage('USER-ERR-02'));
        }
        

        $customer = (new Model('customers'))->update($id,$dataRequest);

        userActiveLog('sửa khách hàng '.$customer->name.'(#'.$customer->id.')');

        // Response
        $res->success(200, Responses::getMessage('CUSTOMER-OK-02'));
    }
    

?>