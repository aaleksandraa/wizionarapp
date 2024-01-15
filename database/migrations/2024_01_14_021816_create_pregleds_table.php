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
        Schema::create('pregleds', function (Blueprint $table) {
            $table->id();
    $table->string('ime_prezime');
    $table->string('telefon')->nullable();
    $table->string('email')->nullable();
    $table->unsignedBigInteger('usluga_id');
    $table->foreign('usluga_id')->references('id')->on('usluges');
    $table->date('datum');
    $table->time('vreme_pocetka');
    $table->time('vreme_kraja');
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregleds');
    }
};
