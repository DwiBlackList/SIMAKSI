<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoinedClass extends Model
{
    protected $table = 'joined_classes';

    protected $fillable = [
        'user_id',
        'mapel_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}
