<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FuzzyKeanggotaan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FuzzyKeanggotaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            // Aksesibilitas
            ['parameter_name' => 'aksesibilitas', 'label_fuzzy' => 'rendah',  'min' => 0, 'mid' => 2, 'max' => 4],
            ['parameter_name' => 'aksesibilitas', 'label_fuzzy' => 'sedang',  'min' => 3, 'mid' => 5, 'max' => 7],
            ['parameter_name' => 'aksesibilitas', 'label_fuzzy' => 'tinggi',  'min' => 6, 'mid' => 8, 'max' => 10],

            // Visibilitas
            ['parameter_name' => 'visibilitas', 'label_fuzzy' => 'rendah',  'min' => 0, 'mid' => 2, 'max' => 4],
            ['parameter_name' => 'visibilitas', 'label_fuzzy' => 'sedang',  'min' => 3, 'mid' => 5, 'max' => 7],
            ['parameter_name' => 'visibilitas', 'label_fuzzy' => 'tinggi',  'min' => 6, 'mid' => 8, 'max' => 10],

            // Daya Beli
            ['parameter_name' => 'daya_beli_masyarakat', 'label_fuzzy' => 'rendah', 'min' => 0, 'mid' => 2, 'max' => 4],
            ['parameter_name' => 'daya_beli_masyarakat', 'label_fuzzy' => 'sedang', 'min' => 3, 'mid' => 5, 'max' => 7],
            ['parameter_name' => 'daya_beli_masyarakat', 'label_fuzzy' => 'tinggi', 'min' => 6, 'mid' => 8, 'max' => 10],

            // Infrastruktur
            ['parameter_name' => 'ketersediaan_infrastruktur', 'label_fuzzy' => 'kurang', 'min' => 0, 'mid' => 2, 'max' => 4],
            ['parameter_name' => 'ketersediaan_infrastruktur', 'label_fuzzy' => 'cukup',  'min' => 3, 'mid' => 5, 'max' => 7],
            ['parameter_name' => 'ketersediaan_infrastruktur', 'label_fuzzy' => 'lengkap','min' => 6, 'mid' => 8, 'max' => 10],

            // Lingkungan
            ['parameter_name' => 'lingkungan_sekitar', 'label_fuzzy' => 'buruk', 'min' => 0, 'mid' => 2, 'max' => 4],
            ['parameter_name' => 'lingkungan_sekitar', 'label_fuzzy' => 'netral','min' => 3, 'mid' => 5, 'max' => 7],
            ['parameter_name' => 'lingkungan_sekitar', 'label_fuzzy' => 'baik',  'min' => 6, 'mid' => 8, 'max' => 10],
        ];

        foreach ($data as $item) {
            FuzzyKeanggotaan::create($item);
        }
    }
}
