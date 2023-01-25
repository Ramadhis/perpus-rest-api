<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Validator;
use App\Services\PayUService\Exception;
use Throwable;

class BukuController extends Controller
{
    public function index()
    {
        $get_book = Buku::all();
        return response()->json($get_book, 200);
    }

    public function find_book($id)
    {
        $get_book = Buku::find($id);
        return response()->json($get_book, 200);
    }

    public function find_buku_dipinjam($id_user)
    {
        /* $get_book = Buku::find($id); 
        return response()->json($get_book->peminjaman,200);
        */
    }

    public function validation_buku($req)
    {
        $validator = Validator::make($req->all(), [
            'no_rak' => 'required|string|max:100',
            'judul' => 'required|string|max:100',
            'pengarang' => 'required|string|max:100',
            'tahun_terbit' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'stok' => 'required|string|max:100',
            'detail' => 'string',
        ]);

        return $validator;
    }

    public function arr_data($req)
    {
        return $data = [
            'no_rak' => $req->no_rak,
            'judul' => $req->judul,
            'pengarang' => $req->pengarang,
            'tahun_terbit' => $req->tahun_terbit,
            'penerbit' => $req->penerbit,
            'stok' => $req->stok,
            'detail' => $req->detail,
        ];
    }

    public function create(Request $req)
    {
        //add
        $validator = $this->validation_buku($req);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            $data = $this->arr_data($req);
            $insert = Buku::create($data);
            $dat['status'] = 'success';
            $dat['data'] = $insert;
            return response()->json($dat, 200);
        } catch (Throwable $err) {
            //function response_error from helper
            $resp = response_error($err->getMessage(), 'failed');
            return response()->json($resp, 404);
        }
    }

    public function update(Request $req, $id)
    {
        //update

        $validator = $this->validation_buku($req);

        if (!$validator) {
            return response()->json($validator->errors());
        }
        try {
            $find = Buku::find($id);
            if (!$find) {
                $resp = response_error('id not found', 'success');
                return response()->json($resp, 200);
            }
            $data = $this->arr_data($req);
            $update = $find->update($data);
            $after_update = Buku::find($id);
            return response()->json($after_update, 200);
        } catch (Throwable $err) {
            //function response_error from helper
            $resp = response_error($err->getMessage(), 'failed');
            return response()->json($resp, 404);
        }
    }

    public function delete_by_id($id)
    {
        //delete
        $data['id'] = $id;
        $validator = Validator::make($data, [
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        try {
            $find = Buku::find($id);
            if (!$find) {
                $resp = response_error('id not found', 'success');
                return response()->json($resp, 200);
            }
            $delete = $find->delete();
            $resp = response_data($delete, 'success');
            return response()->json($resp, 200);
        } catch (Throwable $err) {
            //function response_error from helper
            $resp = response_error($err->getMessage(), 'failed');
            return response()->json($resp, 404);
        }
    }

    public function buku_dipinjam(Request $req)
    {
        //buku_dipinjam
    }
    public function buku_rusak(Request $req)
    {
        //buku_rusak
    }
}
