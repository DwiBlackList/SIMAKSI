<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswaImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'nama' => $row[0],
            'email' => $row[1],
            'kelas' => $row[2],
            'jurusan' => $row[3],
            'nisn_nip' => $row[4],
            'role' => 'siswa',
            'password' => Hash::make($row[5]),
        ]);
    }
}
