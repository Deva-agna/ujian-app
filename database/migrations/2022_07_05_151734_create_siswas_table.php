<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_kelas_id')->nullable()->constrained('sub_kelas');
            $table->string('nama');
            $table->string('nis')->unique();
            $table->string('password');
            $table->string('view_password');
            $table->string('role');
            $table->boolean('status')->default(true);
            $table->string('lulus')->nullable();
            $table->string('slug');
            $table->rememberToken();
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
        Schema::dropIfExists('siswas');
    }
}
