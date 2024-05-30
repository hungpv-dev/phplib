<?php
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $res = new Res();

    $id = getLastStringUri();
    if($requestMethod == 'GET'){

        $check = checkRole(4);
        if(!$check){
            $res->exit(403,Responses::getMessage('USER-ERR-03'));
        }
        
        $res->data = $user;
        $res->success();
    }else if($requestMethod == 'PUT'){

        $dataRequest = json_decode(file_get_contents("php://input"), true);
        
        $currentDateTime = new DateTime();
        $nowTime = $currentDateTime->format('Y-m-d H:i:s');


        // Check role
        $check = checkRole(1);

        if(!$check){
            $res->exit(403,Responses::getMessage('USER-ERR-05'));
        }

        (new Model('user_role'))->where('user_id',$id)->delete();
        
        foreach($dataRequest as $role){
            $data = [
                'user_id' => $id,
                'role_id' => $role,
            ];
            (new Model('user_role'))->create($data);
        }
        $user = (new Model('users'))->find($id);
        userActiveLog('cập nhật nhân viên quyền nhân viên '.$user->name.'(#'.$user->id.')');

        // Response
        $res->success(200, Responses::getMessage('USER-OK-03'));
    }
    

?>