<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSlider extends Model
{
    use HasFactory;
    protected $fillable = ['badge_text', 'title', 'subtitle', 'image', 'link_url'];
}
