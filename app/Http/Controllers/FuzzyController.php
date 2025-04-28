<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\LinguistikNilai;
use App\Models\LocationParameter;
use Illuminate\Support\Facades\DB;

class FuzzyController extends Controller
{

   public function index()
    {
        $locations = Location::with('parameters')->get();
        return view('pages.user.fuzzy.tsukamoto', compact('locations'));
    }



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
    public function hitungFuzzifikasi()
    {
        $params = LocationParameter::with('location')->get();

        foreach ($params as $param) {
            $crisp = app(LokasiController::class)->getCrispValue($param->parameter_name, $param->value);

            // Simulasikan fungsi segitiga:
            $kategoriList = [
                'rendah' => [0, 0, 5],
                'sedang' => [2, 5, 8],
                'tinggi' => [5, 10, 10]
            ];

            foreach ($kategoriList as $kategori => [$a, $b, $c]) {
                $μ = $this->segitiga($crisp, $a, $b, $c);
                if ($μ > 0) {
                    DB::table('fuzzifikasi')->insert([
                        'location_parameter_id' => $param->id,
                        'kategori' => $kategori,
                        'derajat_keanggotaan' => $μ,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return redirect()->route('fuzzy.hasil')->with('success', 'Fuzzifikasi berhasil!');
    }

    private function segitiga($x, $a, $b, $c)
    {
        if ($x <= $a || $x >= $c) return 0;
        elseif ($x == $b) return 1;
        elseif ($x > $a && $x < $b) return ($x - $a) / ($b - $a);
        elseif ($x > $b && $x < $c) return ($c - $x) / ($c - $b);
    }
    public function hasilFuzzifikasi()
    {
        $data = DB::table('fuzzifikasi')
            ->join('location_parameters', 'fuzzifikasi.location_parameter_id', '=', 'location_parameters.id')
            ->join('locations', 'location_parameters.location_id', '=', 'locations.id')
            ->select('locations.name as lokasi', 'location_parameters.parameter_name', 'location_parameters.value',
                    'fuzzifikasi.kategori', 'fuzzifikasi.derajat_keanggotaan')
            ->orderBy('locations.name')
            ->get();

        return view('pages.user.hasil_fuzzifikasi', compact('data'));
    }


}
