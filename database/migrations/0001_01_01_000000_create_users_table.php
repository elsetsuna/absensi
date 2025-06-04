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
            $table->id()->autoIncrement()->primary();
            $table->string('nama')->index();
            $table->string('username')->unique();
            $table->string('jabatan');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('absensi', function (Blueprint $table) {
            $table->id()->autoIncrement()->primary();
            $table->string('nama')->index();
            $table->string('jabatan')->index();
            $table->string('tipe_absensi')->index();
            $table->date('tanggal')->index();
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('status')->default('Hadir');
            $table->string('keterangan')->nullable();
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
