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
        Schema::create('linguistik_nilai', function (Blueprint $table) {
            $table->id();
            $table->string('parameter_name');
            $table->string('label_linguistik');
            $table->integer('nilai_crisp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linguistik_nilai');
    }
};
