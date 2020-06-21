<?php
function successJson($data,$msg='成功'){
    $json=[
        'success'=>true,
        'code'=>0,
        'data'=>$data,
        'msg'=>$msg
    ];

    echo json_encode($json);
    die;
}


function errorJson($msg="失败"){
    $json=[
        'success'=>false,
        'code'=>-1,
        'msg'=>$msg
    ];

    echo json_encode($json);
    die;
}