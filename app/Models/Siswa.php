<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';
    protected $fillable = [
        'id_guru',
        'id_kelas',
        'nis',
        'nama_siswa',
        'jk_siswa',
        'email',
        'alamat_siswa',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_gurus');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelass');
    }
}
