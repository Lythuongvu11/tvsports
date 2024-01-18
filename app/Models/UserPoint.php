<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{
    use HasFactory;
    protected $table = 'user_points';

    protected $fillable = [
        'user_id',
        'points',
        'membership_level',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
