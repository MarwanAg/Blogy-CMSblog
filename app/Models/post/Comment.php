<?php

namespace App\Models\post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table='comments';
    protected $fillable=[
        'id',
        'comment',
        'user_id',
        'user_name',
        'post_id',
        'created_at',
    ];

    public $timestamps=false;
}
