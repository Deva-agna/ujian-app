<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUjiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_b_m_id')->constrained('jadwal_b_m_s');
            $table->string('title');
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->string('waktu_ujian');
            $table->string('type_ujian');
            $table->string('token');
            $table->string('status')->default('pending');
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ujians');
    }
}
