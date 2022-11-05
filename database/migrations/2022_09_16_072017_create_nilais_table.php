<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ujian_id')->constrained('ujians');
            $table->foreignId('siswa_id')->constrained('siswas');
            $table->string('start');
            $table->boolean('status')->default(false);
            $table->string('keterlambatan')->default('-');
            $table->string('nilai')->default('-');
            $table->string('benar')->default('-');
            $table->string('salah')->default('-');
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
        Schema::dropIfExists('nilais');
    }
}
