<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class GuruImport implements ToModel
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
            'role' => $row[2],
            'nisn_nip' => $row[3],
            'password' => Hash::make($row[4]),
        ]);
    }
}
