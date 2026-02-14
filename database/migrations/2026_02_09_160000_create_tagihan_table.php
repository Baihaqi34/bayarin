<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelanggan_id');
            $table->integer('nominal');
            $table->date('periode');
            $table->date('jatuh_tempo');
            $table->string('status')->default('belum_dibayar');
            $table->timestamps();

            $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
            $table->unique(['pelanggan_id', 'periode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};

