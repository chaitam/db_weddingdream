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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('no_hp', 15);
            $table->string('alamat', 255);
            $table->string('nama_vendor', 255);
            $table->string('desc_vendor', 255);
            $table->integer('range_harga');
            $table->integer('kontak_vendor');
            $table->integer('rating_vendor');
            $table->binary('galeri_vendor');
            $table->binary('fotoprofile');
            $table->dateTime('jadwal_vendor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
