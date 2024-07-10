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
        Schema::create('koudens', function (Blueprint $table) {
            $table->id();
            $table->string('section')->comment('名目');
            $table->string('post')->nullable()->comment('所属');
            $table->string('name_kan')->comment('氏名');
            $table->string('relation')->nullable()->comment('続柄');
            $table->string('address')->nullable()->comment('住所');
            $table->string('price')->nullable()->comment('価格');
            $table->text('memo')->nullable()->comment('メモ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koudens');
    }
};
