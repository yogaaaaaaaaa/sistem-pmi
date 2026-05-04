<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penempatans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('wilayah');
        $table->string('id_pmi')->unique();
        $table->string('nama');
        $table->string('negara')->nullable();
        $table->string('p3mi')->nullable();
        $table->string('paspor')->unique();
        $table->integer('tahun_berangkat')->nullable();
        $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('penempatans');
    }
};
