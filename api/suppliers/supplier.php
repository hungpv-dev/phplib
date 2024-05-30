<?php
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $res = new Res();

    $id = getLastStringUri();
    if($requestMethod == 'GET'){

        $check = checkRole(6);
        if(!$check){
            $res->exit(403,Responses::getMessage('SUPPLIERS-ERR-03'));
        }
        // Handle
        $suppliers = (new Model('suppliers','s'))->select('s.*,u.name as user_name')->join('users as u','u.id','s.user_id')->where('s.id',$id)->first();
        
        $res->data = $suppliers;
        $res->success();
    }else if($requestMethod == 'PUT'){

        $dataRequest = json_decode(file_get_contents("php://input"), true);
        
        $currentDateTime = new DateTime();
        $nowTime = $currentDateTime->format('Y-m-d H:i:s');


        // Check role
        $check = checkRole(7);

        if(!$check){
            $res->exit(403,Responses::getMessage('SUPPLIERS-ERR-04'));
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
            }
        }
        if(!empty($check)){
            $res->data = $check;
            $res->exit(422,Responses::getMessage('USER-ERR-02'));
        }
        

        $supplier = (new Model('suppliers'))->update($id,$dataRequest);

        userActiveLog('sửa nhà cung cấp '.$supplier->name.'(#'.$supplier->id.')');

        // Response
        $res->success(200, Responses::getMessage('SUPPLIERS-OK-02'));
    }
    

?>