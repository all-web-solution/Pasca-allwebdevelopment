<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penelitian extends Model
{
    use HasFactory;
    protected $fillable = ['judul_riset', 'penulis', 'jurnal_nama', 'tahun', 'link_jurnal'];
}
