<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapels';

    protected $fillable = [
        'nama_mapel',
        'semester',
    ];

    public function joinedclass()
    {
        return $this->hasMany(JoinedClass::class);
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }

    public function users()
{
    // semua user yang “join” mapel ini via joined_classes
    return $this->belongsToMany(User::class, 'joined_classes', 'mapel_id', 'user_id');
}
}
