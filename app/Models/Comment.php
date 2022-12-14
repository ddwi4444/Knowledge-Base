<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $table = "comments";

    protected $fillable = [
        'nama', 'comment', 'id_post', 'username', 'id_unit', 'id_parent', 'status',
    ];
}
