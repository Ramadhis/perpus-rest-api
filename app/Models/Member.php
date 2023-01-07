<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "member";
    protected $fillable = ['no_ktp','nama','alamat','tgl_lahir'];
    
    public function peminjaman() {
        return $this->hasMany('Apps\Models\Peminjaman','id_member');
    }
}