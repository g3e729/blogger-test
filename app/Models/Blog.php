<?php

namespace App\Models;

use App\Traits\HasLike;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, HasLike, SoftDeletes;

    protected $fillable = [
        'title',
        'content'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
	
}