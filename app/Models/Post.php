<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $table = "posts";

    protected $fillable = [
        'id_unit', 'judul_post', 'isi_post', 'image', 'tags', 'slug',
    ];
}
