<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswas';

    protected $fillable = [
        'npm',
        'nama',
        'angkatan',
        'email',
        'sudah_vote',
    ];

    public $timestamps = true;
}
