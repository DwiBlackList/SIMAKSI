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

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }
}
