<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $table = 'kehadirans';

    protected $fillable = [
        'user_id',
        'hadir',
        'absen',
        'sakit',
        'ijin',
        'semester',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
