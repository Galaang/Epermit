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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->string('nip',18)->unique();
            $table->string('name',50);
            $table->string('email',50)->unique()->nullable();
            $table->unsignedBigInteger('pangkat_jabatan_id');
            $table->unsignedBigInteger('jabatan_id');
            $table->unsignedBigInteger('unit_id');
            $table->string('password',60);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('jabatan_id')->references('id')->on('jabatans');
            $table->foreign('pangkat_jabatan_id')->references('id')->on('pangkat_jabatans');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('unit_id')->references('id')->on('unit_kerjas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
