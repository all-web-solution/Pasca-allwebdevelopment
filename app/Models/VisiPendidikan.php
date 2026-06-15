<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisiPendidikan extends Model
{
    use HasFactory;
    protected $fillable = ['judul_visi', 'deskripsi_visi', 'gambar_visi'];
}
