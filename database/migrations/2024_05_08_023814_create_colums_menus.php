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
      Schema::table('menus', function (Blueprint $table) {
            $table->unsignedInteger('parent')->default(0)->after('slug');
            $table->smallInteger('order')->default(0)->after('parent');
            $table->boolean('enabled')->default(1)->after('order');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
