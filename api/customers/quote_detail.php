<?php
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $res = new Res();

    $id = getLastStringUri();
    if($requestMethod == 'GET'){

        $check = checkRole(21);
        if(!$check){
            $res->exit(403,Responses::getMessage('QUOTES-ERR-01'));
        }
        // Handle
        $quote_detail = (new Model('quote_details','q'))->select('q.*, p.name as product_name,p.category_id')->leftJoin('products p','p.id','q.product_id')->where('q.id',$id)->first();
        
        $res->data = $quote_detail;
        $res->success();
    }else if($requestMethod == 'PUT'){

        $dataRequest = json_decode(file_get_contents("php://input"), true);
        
        $currentDateTime = new DateTime();
        $nowTime = $currentDateTime->format('Y-m-d H:i:s');


        // Check role
        $check = checkRole(22);

        if(!$check){
            $res->exit(403,Responses::getMessage('QUOTES-ERR-03'));
        }

        $check = [];
        // Validate
        foreach($dataRequest as $key => $value){
            if($value == '' && $key != 'note'){
                $check[$key] = $key .' không được để trống';
            }
        }
        if(!empty($check)){
            $res->data = $check;
            $res->exit(422,Responses::getMessage('USER-ERR-02'));
        }
        

        $quote_detail = (new Model('quote_details'))->update($id,$dataRequest);

        userActiveLog('sửa báo giá chi tiết: sản phẩm ' . $quote_detail->product_id . ' id báo giá: (#' . $quote_detail->id . ')');

        // Response
        $res->success(200, Responses::getMessage('QUOTES-OK-02'));
    }else if($requestMethod == 'DELETE'){
        $check = checkRole(24);

        if(!$check){
            $res->exit(403,Responses::getMessage('QUOTE-DETAILS-ERR-04'));
        }
        $quote_detail = (new Model('quote_details'))->find($id);
        (new Model('quote_details'))->destroy($id);
        userActiveLog('xóa báo giá chi tiết: sản phẩm ' . $quote_detail->product_id . ' id báo giá: (#' . $quote_detail->id . ')');
        $res->success(200, Responses::getMessage('QUOTE-DETAIL-OK-02'));
    }
    

?>