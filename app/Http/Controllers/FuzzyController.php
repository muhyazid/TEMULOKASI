<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\LinguistikNilai;

class FuzzyController extends Controller
{
    // Step 2 & 3: Konversi Linguistik ke Crisp
    public function konversiCrisp()
    {
        $locations = Location::with('parameters')->get();

        foreach ($locations as $location) {
            foreach ($location->parameters as $param) {
                // Cari di tabel linguistik_nilai berdasarkan nama parameter dan label linguistik
                $crisp = LinguistikNilai::where('parameter_name', $param->parameter_name)
                    ->where('label_linguistik', $param->value)
                    ->first();

                // Simpan hasil konversi sebagai nilai_crisp baru di kolom tambahan (optional)
                if ($crisp) {
                    $param->nilai_crisp = $crisp->nilai_crisp;
                } else {
                    $param->nilai_crisp = null; // jika tidak ketemu, bisa diset null atau default
                }
            }
        }

        return view('pages.user.konversi_crisp', compact('locations'));
    }
}
