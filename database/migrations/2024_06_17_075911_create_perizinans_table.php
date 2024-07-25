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
        Schema::create('perizinans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nama',50);
            $table->string('nip',18);
            $table->string('pangkat_jabatan',50);
            $table->string('jabatan',50);
            $table->string('unit_kerja',50);
            $table->string('jenis_izin');
            $table->time('waktu')->nullable();
            $table->integer('izin_ke');
            $table->date('tanggal');
            $table->string('alasan',50);
            $table->string('status');
            $table->string('bukti')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perizinans');
    }
};
