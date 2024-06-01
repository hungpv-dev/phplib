<?php
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $res = new Res();

    $id = getLastStringUri();
    if($requestMethod == 'GET'){

        $check = checkRole(15);
        if(!$check){
            $res->exit(403,Responses::getMessage('VATTU-ERR-01'));
        }
        // Handle
        $vattu = (new Model('vat_tu'))->find($id);
        
        $res->data = $vattu;
        $res->success();
    }else if($requestMethod == 'PUT'){

        $dataRequest = json_decode(file_get_contents("php://input"), true);
        
        $currentDateTime = new DateTime();
        $nowTime = $currentDateTime->format('Y-m-d H:i:s');


        // Check role
        $check = checkRole(17);

        if(!$check){
            $res->exit(403,Responses::getMessage('VATTU-ERR-03'));
        }

        $check = [];
        // Validate
        foreach($dataRequest as $key => $value){
            if ($value == '' && $key != 'description') {
                $check[$key] = $key . ' không được để trống';
            }
        }
        if(!empty($check)){
            $res->data = $check;
            $res->exit(422,Responses::getMessage('USER-ERR-02'));
        }
        

        $vattu = (new Model('vat_tu'))->update($id,$dataRequest);

        userActiveLog('thêm vật tư ' . $vattu->name . '(#' . $vattu->id . ')');

        // Response
        $res->success(200, Responses::getMessage('VATTU-OK-02'));
    }
    

?>