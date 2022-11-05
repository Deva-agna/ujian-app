<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailJawabanEssaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_jawaban_essays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jawaban_id')->constrained('jawabans');
            $table->text('jawaban')->nullable();
            $table->string('gambar')->nullable();
            $table->string('nilai')->nullable();
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
        Schema::dropIfExists('detail_jawaban_essays');
    }
}
