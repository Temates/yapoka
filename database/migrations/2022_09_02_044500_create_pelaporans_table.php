<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelaporans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idpengisidata');
            $table->foreign('idpengisidata')->references('id')->on('users');
            $table->string('title');            
            $table->integer('status_penyetuju_nomer');
            $table->string('note')->nullable();
            $table->integer('jumlah_penyetuju');
            $table->string('list_id_penyetuju');
            $table->boolean('status_laporan')->default('0');
            $table->integer('idsekarang');
            $table->boolean('confirmed')->nullable()->default(false);            
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
        Schema::dropIfExists('pelaporans');
    }
};
