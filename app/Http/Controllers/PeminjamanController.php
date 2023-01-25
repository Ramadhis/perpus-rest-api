<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Validator;
use App\Services\PayUService\Exception;
use Throwable;

class PeminjamanController extends Controller
{

    public function index()
    {
        try {
            $all = Peminjaman::all();
            $resp = response_data($all, 'success');
            return response()->json($resp);
        } catch (Throwable $err) {
            $resp = response_error($err->getMessage(), 'failed');
            return response()->json($resp, 404);
        }
    }

    public function find_peminjam_byMemberId($id_member)
    {
        $data['id_member'] = $id_member;
        $validator = Validator::make($data, [
            'id_member' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            $find = Peminjaman::where('id_member', $id_member)->get();
            $resp = response_data($find, 'success');
            return response()->json($resp);
        } catch (Throwable $err) {
            $resp = response_error($err->getMessage(), 'failed');
            return response()->json($resp, 404);
        }
    }

    public function peminjaman(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'id_buku' => 'required|integer|max:100',
            'id_member' => 'required|integer|max:100',
            'tgl_pinjam' => 'required|date_format:d/m/Y',
            'tgl_pengembalian' => 'required|date_format:d/m/Y',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            $find = Peminjaman::create([
                'id_buku' => $req->id_buku,
                'id_member' => $req->id_member,
                'tgl_pinjam' => $req->tgl_pinjam,
                'tgl_pengembalian' => $req->tgl_pengembalian,
            ]);
            $resp = response_data($find, 'success');
            return response()->json($resp);
        } catch (Throwable $err) {
            $resp = response_error($err->getMessage(), 'failed');
            return response()->json($resp, 404);
        }
    }

    public function update(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'id_buku' => 'required|integer|max:100',
            'id_member' => 'required|integer|max:100',
            'tgl_pinjam' => 'required|date_format:d/m/Y',
            'tgl_pengembalian' => 'required|date_format:d/m/Y',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            $find = Peminjaman::find($id);
            if (!$find) {
                $resp = response_error('id not found', 'success');
                return response()->json($resp, 200);
            }
            $update = $find->update([
                'id_buku' => $req->id_buku,
                'id_member' => $req->id_member,
                'tgl_pinjam' => $req->tgl_pinjam,
                'tgl_pengembalian' => $req->tgl_pengembalian,
            ]);
            $resp = response_data($update, 'success');
            return response()->json($resp);
        } catch (Throwable $err) {
            $resp = response_error($err->getMessage(), 'failed');
            return response()->json($resp, 404);
        }
    }

    public function pengembalian($id)
    {
        try {
            $find = Peminjaman::find($id);
            if (!$find) {
                $resp = response_error('id not found', 'success');
                return response()->json($resp, 200);
            }

            if ($find->status_pengembalian == 1) {
                //mengembalikan pengembalian menjadi false kembali
                $update = $find->update(['status_pengembalian' => 0]);
            } elseif ($find->status_pengembalian == 0) {
                //mengubah pengembalian menjadi true
                $update = $find->update(['status_pengembalian' => 1]);
            }

            $resp = response_data($update, 'success');
            return response()->json($resp);
        } catch (Throwable $err) {
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
            $find = Peminjaman::find($id);
            if (!$find) {
                $resp = response_error('id not found', 'success');
                return response()->json($resp, 200);
            }
            $delete = $find->delete();
            $resp = response_data($delete, 'success');
            return response()->json($resp);
        } catch (Throwable $err) {
            $resp = response_error($err->getMessage(), 'failed');
            return response()->json($resp, 404);
        }
    }
}
