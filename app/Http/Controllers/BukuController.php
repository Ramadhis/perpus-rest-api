<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;

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
}