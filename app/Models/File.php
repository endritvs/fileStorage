<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $table = "files";
    protected $fillable = [
        'user_id','filename','filepath'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
