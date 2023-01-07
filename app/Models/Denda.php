<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Denda extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "denda";
    protected $fillable = ['id_member','id_buku','jumlah_denda','jenis_denda','deskripsi'];
}