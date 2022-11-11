<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_b_m_id')->constrained('jadwal_b_m_s');
            $table->foreignId('mapel_id')->constrained('mapels');
            $table->foreignId('kelas_id')->constrained('kelas');
            $table->string('title');
            $table->text('soal');
            $table->string('image');
            $table->string('type_soal');
            $table->boolean('status_update')->default(true);
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
        Schema::dropIfExists('soals');
    }
}
