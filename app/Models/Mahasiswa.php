<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Mahasiswa extends Authenticatable
{
    use Notifiable;

    protected $table = 'mahasiswas';

    protected $fillable = [
        'npm',
        'nama',
        'angkatan',
        'email',
        'sudah_vote',
        'role',
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';

    // If your users are identified by 'npm' instead of 'id', you can
    // override the primary key. By default we keep 'id' as primary key.
    // protected $primaryKey = 'id';
}
