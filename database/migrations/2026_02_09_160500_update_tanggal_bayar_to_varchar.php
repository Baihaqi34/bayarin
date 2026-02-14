<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->string('tanggal_bayar', 10)->change();
            $table->enum('status', ['aktif', 'nonaktif'])->change();
        });
    }

    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->string('tanggal_bayar', 10)->change();
            $table->enum('status', ['aktif', 'nonaktif'])->change();
        });
    }
};

