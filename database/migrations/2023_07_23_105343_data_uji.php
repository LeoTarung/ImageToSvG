<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DataUji extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('db_uji', function (Blueprint $table) {
            $table->id('no');
            $table->string('nama_karyawan');
            $table->string('jabatan');
            $table->string('sp');
            $table->string('status_karyawan');
            $table->string('kompetensi');
            $table->string('intelektual');
            $table->string('ketelitian');
            $table->string('komunikasi');
            $table->string('loyalitas');
            $table->string('kerjasama');
            $table->string('disiplin');
            $table->string('inisiatif');
            $table->string('sikap');
            $table->string('hasil');
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
        //
    }
}
