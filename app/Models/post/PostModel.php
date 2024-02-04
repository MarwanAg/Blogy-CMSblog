<?php

namespace App\Models\post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    use HasFactory;

    protected $table='posts';
    protected $fillable = [
        "id",
        "title",
        "description",
        "image",
        "category",
        "user_id",
        "user_name",
        "created_at",
        "image"
    ];
    public $timestamps=false;
}
