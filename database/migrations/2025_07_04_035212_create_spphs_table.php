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
        Schema::create('spphs', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_spph');
            $table->string('tanggal_masuk');
            $table->string('vendor');
            $table->string('metode_ppbj');
            $table->string('note_spph')->nullable();
	        $table->string('file_spph')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spphs');
    }
};
