<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    protected $fillable = ['judul_seminar', 'tanggal_pelaksanaan', 'deskripsi_singkat', 'tags_pencarian'];
}
