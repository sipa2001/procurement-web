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
        Schema::create('progress', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('function');
            $table->string('month');
            $table->string('image')->nullable();
            $table->string('ppbj_jumlah')->nullable();
            $table->string('ppbj_nilai')->nullable();
            $table->string('ppbj_cancel')->nullable();
            $table->string('ppbj_persentase')->nullable();
            $table->string('kontrak_jumlah')->nullable();
            $table->string('kontrak_nilai')->nullable();
            $table->string('kontrak_persentase')->nullable();
            $table->string('barang_datang_jumlah')->nullable();
            $table->string('barang_datang_persentase')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress');
    }
};
