<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fuzzy_keanggotaan', function (Blueprint $table) {
            $table->id();
            $table->string('parameter_name'); // misalnya: aksesibilitas
            $table->string('label_fuzzy'); // misalnya: rendah, sedang, tinggi
            $table->float('min'); // batas bawah fungsi segitiga/trapesium
            $table->float('mid'); // titik puncak / tengah
            $table->float('max'); // batas atas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuzzy_keanggotaan');
    }
};
