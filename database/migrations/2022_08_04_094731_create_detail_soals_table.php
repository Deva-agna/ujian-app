<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailSoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_soals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soal_id')->constrained('soals');
            $table->text('jawaban')->nullable();
            $table->string('image')->nullable();
            $table->string('kunci_jawaban')->default(false);
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
        Schema::dropIfExists('detail_soals');
    }
}
