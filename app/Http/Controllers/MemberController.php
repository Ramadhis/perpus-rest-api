<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Validator;
use Throwable;

class MemberController extends Controller
{
    public function index(){
        $get_book = Member::all();
        return response()->json($get_book,200);
    }

    public function find_member($id){
        $get_book = Member::find($id);
        return response()->json($get_book,200);
    }

    public function arr_data($req){
        return [
            'no_ktp' => $req->no_ktp,
            'nama' => $req->nama, 
            'alamat' => $req->alamat,
            'tgl_lahir' => $req->tgl_lahir,
        ];
    }

    public function validation($req){
        $validator = Validator::make($req->all(),[
            'no_ktp' => 'required|string|max:100',
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:100',
            'tgl_lahir' => 'required|string|max:10',
        ]);

        return $validator;
    }

    public function create(Request $req){
        $validator = $this->validation($req);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        try {
            $data = $this->arr_data($req);
            $insert = Member::create($data);

						//reponse_data from helpers
						$resp = response_data($insert,'success');
						return response()->json($resp);
        } catch (Throwable $err) {
						$resp = response_error($err->getMessage(),'failed');
            return response()->json($resp,404);
        }
    }

    public function update(Request $req,$id){
        $validator = $this->validation($req);

        if(!$validator){
            return response()->json($validator->errors());
        }

        try {
            $find = Member::find($id);
            $data = $this->arr_data($req);
            $update = $find->update($data);
						// function response_data from helper
						$resp = response_data($update,'success');
						return response()->json($resp,200);
        } catch (Throwable $err) {
						//function response_error from helper
						$resp = response_error($err->getMessage(),'failed');
            return response()->json($data,404);
        }
    }

    public function delete_by_id($id) {
        //delete
        $data['id'] = $id; 
        $validator = Validator::make($data,[
            'id' => 'required|integer',
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors());
        }

        try {
            $find = Member::find($id);
				
			if(!$find){
				$resp = response_error('id not found','failed');
				return response()->json($resp,404);
			}
			$delete = $find->delete();
			$resp = response_data($delete,'success');
            return response()->json($resp,200);
        } catch (Throwable $err) {
            //function response_error from helper
						$resp = response_error($err->getMessage(),'failed');
            return response()->json($resp,404);
        }
    }


}
