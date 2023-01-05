<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index(){
        $get_book = Book::all();
        return response()->json($get_book,200);
    }

    public function get_token(Request $req) {
        return $req->bearerToken();
    }
}