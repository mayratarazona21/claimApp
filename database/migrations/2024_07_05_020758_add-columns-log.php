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
      Schema::table('logs', function (Blueprint $table) {
        $table->unsignedBigInteger('action_id')->after('user_id')->nullable();
        $table->foreign('action_id')->references('id')->on('dictionary');
        $table->integer('target_id')->after('action_id')->nullable();
        $table->string('target_table')->after('target_id')->nullable();
        $table->string('description')->after('target_table')->nullable();
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
