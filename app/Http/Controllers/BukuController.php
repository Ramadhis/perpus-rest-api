<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    public function index(){
        $get_book = Buku::all();
        return response()->json($get_book,200);
    }

    public function list_peminjam($id){
        $get_book = Buku::find($id);
        return response()->json($get_book->peminjaman,200);
    }

    public function get_token(Request $req) {
        return $req->bearerToken();
    }

    public function validation_buku($req){
        $validator = Validator::make($req->all(),[
            'no_rak' => 'required|string|max:100',
            'judul' => 'required|string|max:100',
            'pengarang' => 'required|string|max:100',
            'tahun_terbit' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'stok' => 'required|string|max:100',
            'detail' => 'string',
        ]);
        
        if($validator->fails()){
            return false;
        }else {
            return $validator;
        }
    }

    public function add(Request $req) {
        //add
        $validator = validation_buku($req);

        if(!$validator){
            return response()->json($validator->errors());
        }
    }
    public function update(Request $req) {
        //update
        $validator = validation_buku($req);

        if(!$validator){
            return response()->json($validator->errors());
        }
    }
    public function delete(Request $req) {
        //delete
    }
    public function buku_dipinjam(Request $req) {
        //buku_dipinjam
    }
    public function buku_rusak(Request $req) {
        //buku_rusak
    }

}