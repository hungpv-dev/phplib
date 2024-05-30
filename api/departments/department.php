<?php
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $res = new Res();

    $id = getLastStringUri();
    if($requestMethod == 'GET'){

        $check = checkRole(8);
        if(!$check){
            $res->exit(403,Responses::getMessage('DEPARTMENT-ERR-01'));
        }
        // Handle
        $department = (new Model('departments'))->find($id);
        
        $res->data = $department;
        $res->success();
    }else if($requestMethod == 'PUT'){

        $dataRequest = json_decode(file_get_contents("php://input"), true);
        
        $currentDateTime = new DateTime();
        $nowTime = $currentDateTime->format('Y-m-d H:i:s');


        // Check role
        $check = checkRole(10);

        if(!$check){
            $res->exit(403,Responses::getMessage('DEPARTMENT-ERR-03'));
        }
        

        $user = (new Model('users'))->update($dataRequest['user_id'],['department_id' => $dataRequest['department_id']]);
        $department = (new Model('departments'))->find($user->department_id);

        userActiveLog('đưa  '.$user->name.'(#'.$user->id.') tới phòng ban '.$department->name.'(#'.$department->id.')');

        $res->data = $user;
        $res->success(200, Responses::getMessage('DEPARTMENT-OK-02'));
    }else if($requestMethod == 'DELETE'){
        (new Model('users'))->update($id,['department_id' => 0]);
        $res->success(204);
    }   
    

?>