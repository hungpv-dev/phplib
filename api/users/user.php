<?php
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $res = new Res();

    $id = getLastStringUri();
    if($requestMethod == 'GET'){

        $check = checkRole(4);
        if(!$check){
            $res->exit(403,Responses::getMessage('USER-ERR-03'));
        }
        // Handle
        $user = (new Model('users'))->find($id);
        
        $res->data = $user;
        $res->success();
    }else if($requestMethod == 'PUT'){

        $dataRequest = json_decode(file_get_contents("php://input"), true);
        
        $currentDateTime = new DateTime();
        $nowTime = $currentDateTime->format('Y-m-d H:i:s');


        // Check role
        $check = checkRole(3);

        if(!$check){
            $res->exit(403,Responses::getMessage('USER-ERR-04'));
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
        

        $user = (new Model('users'))->update($id,$dataRequest);

        userActiveLog('sửa nhân viên '.$user->name.'(#'.$user->id.')');

        // Response
        $res->success(200, Responses::getMessage('USER-OK-02'));
    }
    

?>