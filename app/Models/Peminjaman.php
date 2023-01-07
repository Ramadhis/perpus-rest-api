<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peminjaman extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "peminjaman";
    protected $fillable = ['id_member','id_buku','tgl_pinjam','tgl_pengembalian','status_pengembalian'];

    // public function member(){
    //     return $this->belongsTo('Apps\Models\Member',);
    // }

    public function buku(){
        return $this->belongsTo(Buku::class,'id','id_buku');
    }
    
}