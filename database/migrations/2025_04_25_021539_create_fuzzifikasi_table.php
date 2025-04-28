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
        Schema::create('fuzzifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_parameter_id')->constrained('location_parameters')->onDelete('cascade');
            $table->string('kategori'); // rendah, sedang, tinggi
            $table->double('derajat_keanggotaan'); // nilai μ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuzzifikasi');
    }
};
