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
        //
        Schema::table('location_parameters', function (Blueprint $table) {
            $table->string('parameter_name')->change();
            $table->string('business_type')->after('location_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('location_parameters', function (Blueprint $table) {
            $table->dropColumn('business_type');
        });
    }
};
