<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    $permissions = [
      'view administration',
      'view user-management',
      'create user-management',
      'update user-management',
      'delete user-management',
      'view roles',
      'create roles',
      'update roles',
      'delete roles',
    ];

    foreach ($permissions as $permission) {
      Permission::create([
        'name' => $permission,
        'guard_name' => 'web',
      ]);
    }
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    $permissions = [
      'view administration',
      'view user-management',
      'create user-management',
      'update user-management',
      'delete user-management',
      'view roles',
      'create roles',
      'update roles',
      'delete roles',
    ];

    foreach ($permissions as $permission) {
      Permission::where('name', $permission)
        ->where('guard_name', 'web')
        ->delete();
    }
  }
};
