<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banners';

    protected $fillable = [
        'image',
        'title',
        'sub_title',
        'description',
        'button_text',
        'link',
        'text_color',
        'display_on'
    ];
}
