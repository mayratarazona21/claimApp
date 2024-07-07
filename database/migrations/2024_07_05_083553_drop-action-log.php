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
        $table->string('details')->nullable()->change();
        $table->dropColumn('action');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::table('logs', function (Blueprint $table) {
        $table->string('details')->nullable(false)->change();
        $table->string('action');
    });
    }
};
