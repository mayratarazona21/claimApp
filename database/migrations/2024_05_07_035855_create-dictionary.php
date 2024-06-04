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
      Schema::create('dictionary', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->unsignedBigInteger('id_type');
        $table->foreign('id_type')->references('id')->on('type_dictionary');
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
