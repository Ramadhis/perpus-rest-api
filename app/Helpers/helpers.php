<?php 
    function response_data($data,$status){
        //success [string]
        $res['status'] = $status;

        //response data
        $res['data'] = $data;

        //return
        return $res;
	}

	function response_error($error,$status){
		//failed status [string]
		$res['status'] = $status;

		//response data
		$res['error'] = $error;
		
		//return
		return $res;
	}
?>
