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
      Schema::table('roles', function (Blueprint $table) {
          $table->unsignedBigInteger('id_status')->default(1)->after('guard_name')->nullable();
          $table->foreign('id_status')->references('id')->on('dictionary');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
