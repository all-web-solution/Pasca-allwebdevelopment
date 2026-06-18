<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruBesar extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'gelar_depan', 'gelar_belakang', 'bidang_keahlian', 'foto', 'biografi_singkat', 'prodi_id'];

    public function prodi()
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi_id');
    }
}
