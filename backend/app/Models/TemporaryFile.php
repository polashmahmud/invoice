<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryFile extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'path', 'folder', 'name', 'extension', 'size', 'mime_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
