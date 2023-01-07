<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "buku";
    protected $fillable = ['no_rak','judul','pengarang','tahun_terbit','penerbit','stok','detail'];

    public function peminjaman(){
        return $this->hasMany(Peminjaman::class,'id_buku','id');
    }
}