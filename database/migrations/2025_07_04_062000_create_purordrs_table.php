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
        Schema::create('purordrs', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_purordr');
            $table->string('tanggal_masuk');
            $table->string('note_purordr')->nullable();
	        $table->string('file_purordr')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purordrs');
    }
};
