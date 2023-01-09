<?php

namespace App\Http\Controllers\Api;

trait GeneralApiTrait
{
    public function returnData($data=null, $msg = null,$status=null)
    {
        $array=[
            'data'=>$data,
            'message'=>$msg,
            'status'=>$status,
        ];
        return response()->json($array,$status);
    }

    public function returnError($errNum, $msg)
    {
        return response()->json([
            'status' => false,
            'errNum' => $errNum,
            'msg' => $msg
        ]);
    }
}
