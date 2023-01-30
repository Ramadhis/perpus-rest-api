<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denda;
use Illuminate\Support\Facades\Validator;
use App\Services\PayUService\Exception;
use Throwable;

class DendaController extends Controller
{
    public function index()
    {
        try {
            $all = Denda::all();
            $resp = response_data($all, 'success');
            return response()->json($resp);
        } catch (Throwable $err) {
            $resp = response_error($err->getMessage(), 'failed');
            return response()->json($resp, 404);
        }
    }

    public function find_by_memberId($id_member)
    {
        try {
            $find = Denda::find($id_member);
            $resp = response_data($find, 'success');
            return response()->json($resp);
        } catch (Throwable $err) {
            $resp = response_error($err->getMessage(), 'failed');
            return response()->json($resp, 404);
        }
    }

    public function validation($req)
    {
        return Validator::make(
            $req->all,
            [
                'id_member' => 'required|integer|max:100',
                'id_buku' => 'required|integer|max:100',
                'jumlah_denda' => 'required|string|max:100',
                'jenis_denda' => 'required|string|max:100',
                'deskripsi' => 'required|string'
            ]
        );
    }

    public function create(Request $req)
    {
        $validator = $this->validation($req);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            $create = Denda::create([
                'id_member' => $req->id_member,
                'id_buku' => $req->id_buku,
                'jumlah_denda' => $req->jumlah_denda,
                'jenis_denda' => $req->jenis_denda,
                'deskripsi' => $req->deskripsi,
            ]);
            $resp = response_data($create, 'success');
            return response()->json($resp);
        } catch (Throwable $err) {
            $resp = response_error($err->getMessage(), 'failed');
            return response()->json($resp, 404);
        }
    }

    public function update(Request $req, $id)
    {
        $validator = $this->validation($req);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            $find = Denda::find($id);
            if (!$find) {
                $resp = response_data('data not found', 'success');
                return response()->json($resp);
            }
            $data = $this->arr_data($req);
            $update = $find->update($data);
            $resp = response_data($update, 'success');
            return response()->json($resp);
        } catch (Throwable $err) {
            $resp = response_error($err->getMessage(), 'failed');
            return response()->json($resp, 404);
        }
    }

    public function delete_by_id($id)
    {
        $data['id'] = $id;
        $validator = Validator::make($data, ['id' => 'required|integer']);
        if ($validator->fails()) {
            $resp = response_data('data not found', 'success');
            return response()->json($resp, 200);
        }
        try {
            $find = Denda::find($id);
            if (!$find) {
                $resp = response_data('data not found', 'success');
                return response()->json($resp);
            }
            $delete = $find->delete($data);
            $resp = response_data($delete, 'success');
            return response()->json($resp);
        } catch (Throwable $err) {
            $resp = response_error($err->getMessage(), 'failed');
            return response()->json($resp, 404);
        }
    }

    public function arr_data($req)
    {
        return [
            'id_member' => $req->id_member,
            'id_buku' => $req->id_buku,
            'jumlah_denda' => $req->jumlah_denda,
            'jenis_denda' => $req->jenis_denda,
            'deskripsi' => $req->deskripsi,
        ];
    }
}
