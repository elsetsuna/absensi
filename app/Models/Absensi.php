<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $table = 'absensi';

protected $fillable = ['nama', 'jabatan', 'tipe_absensi', 'tanggal', 'status', 'keterangan', 'waktu_mulai', 'waktu_selesai'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
