<?php

namespace App\Imports;

use App\Models\KaryawanModel;
use Maatwebsite\Excel\Concerns\ToModel;

class KaryawanImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new KaryawanModel([
            'no' => $row[0],
            'nama_karyawan' => $row[1],
            'jabatan' => $row[2],
            'sp' => $row[3],
            'status_karyawan' => $row[4],
            'kompetensi' => $row[5],
            'intelektual' => $row[6],
            'ketelitian' => $row[7],
            'komunikasi' => $row[8],
            'loyalitas' => $row[9],
            'kerjasama' => $row[10],
            'disiplin' => $row[11],
            'inisiatif' => $row[12],
            'sikap' => $row[13],
            'hasil' => $row[14]
            //
        ]);
    }
}
