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
        Schema::create('location_parameters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id')->index(); // Gunakan bigInteger dan tambahkan index
            $table->string('parameter_name');
            $table->double('value'); // Ubah integer ke double agar lebih fleksibel
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_parameters');
    }
};
