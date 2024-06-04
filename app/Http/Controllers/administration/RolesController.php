<?php

namespace App\Http\Controllers\administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\SubMenu;
use \stdClass;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomRole;
use App\Services\HashidsService;

class RolesController extends Controller
{
  protected $hashidsService;

  public function __construct(HashidsService $hashidsService)
  {
    $this->hashidsService = $hashidsService;
  }

  public function index()
  {
    $roles = CustomRole::join('dictionary AS s', 's.id', '=', 'roles.id_status')
      ->select('roles.id', 'roles.name AS role', 's.name as status', 'roles.created_at AS creation_date', 'id_status')
      ->get();
    return view('administration.roles.roles', compact('roles'));
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $nureavr = 'sdkf';
    $flag = 'create';
    $bAdministratorAccess = false;
    $rol = new CustomRole();
    $title = trans('addNewRol');
    $menuList = Menu::menus();
    $permissions = Permission::all();
    $permissionsRole = '';

    return view(
      'administration.roles.rol',
      compact('menuList', 'flag', 'rol', 'title', 'bAdministratorAccess', 'permissions', 'permissionsRole')
    );
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|max:50',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'name' => 'Warning',
        'state' => 'warning',
        'message' => $validator->errors()->all(),
      ]);
    }

    $rol = CustomRole::where('name', ucfirst($request->name))
      ->where('id_status', '=', 1)
      ->count();
    if ($rol > 0) {
      return response()->json([
        'name' => 'Warning',
        'state' => 'warning',
        'message' => trans('roleNameExists'),
      ]);
    } else {
      $role = CustomRole::create([
        'name' => ucfirst($request->name),
        'guard_name' => 'web',
        'id_status' => 1,
      ])->syncPermissions($request->permissions);
      //Log::logCrear(Auth()->user()->id, 'roles', $role->id, ['nombre' => $role->name]);

      return response()->json([
        'name' => 'Success',
        'state' => 'success',
        'message' => trans('messageRolOk'),
      ]);
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($encrypted_id)
  {
    $flag = 'edit';
    $title = trans('editRole');
    $id = $this->hashidsService->decode($encrypted_id)[0];
    $rol = CustomRole::findOrFail($id);

    $menuList = Menu::menus();
    $permissions = Permission::all();
    $permissionsRole = $rol->permissions->pluck('name');

    $bAdministratorAccess = Permission::count() == $permissionsRole->count();
    return view(
      'administration.roles.rol',
      compact('menuList', 'rol', 'permissionsRole', 'flag', 'title', 'bAdministratorAccess', 'permissions')
    );
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $encrypted_id)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:50',
    ]);

    $id = $this->hashidsService->decode($encrypted_id)[0];

    if ($validator->fails()) {
      return response()->json([
        'name' => 'Warning',
        'state' => 'warning',
        'message' => $validator->errors()->all(),
      ]);
    }

    $rol = CustomRole::where('name', ucfirst($request->name))
      ->where('id', '!=', $id)
      ->where('id_status', '=', 1)
      ->count();

    if ($rol > 0) {
      return response()->json([
        'name' => 'Warning',
        'state' => 'warning',
        'message' => trans('roleNameExists'),
      ]);
    } else {
      $role = CustomRole::findOrFail($id);
      $role->update(['name' => ucfirst($request->name)]);
      $role->syncPermissions($request->permissions);

      return response()->json([
        'name' => 'Success',
        'state' => 'success',
        'message' => trans('messageRolOk'),
      ]);
    }
  }

  function show($encrypted_id)
  {
    $flag = 'view';
    $title = trans('viewRole');
    $id = $this->hashidsService->decode($encrypted_id)[0];
    $rol = CustomRole::findOrFail($id);

    $menuList = Menu::menus();
    $permissions = Permission::all();
    $permissionsRole = $rol->permissions->pluck('name');

    $bAdministratorAccess = Permission::count() == $permissionsRole->count();
    return view(
      'administration.roles.rol',
      compact('menuList', 'rol', 'permissionsRole', 'flag', 'title', 'bAdministratorAccess', 'permissions')
    );
  }

  function destroy($encrypted_id)
  {
    $id = $this->hashidsService->decode($encrypted_id)[0];
    $rol = CustomRole::findOrFail($id);

    if ($rol->users->count() > 0) {
      $rol->id_status = 2;
      if ($rol->save()) {
        return response()->json([
          'name' => 'Success',
          'state' => 'success',
          'message' => trans('roleInactiveOk'),
        ]);
      } else {
        return response()->json([
          'name' => 'Warning',
          'state' => 'warning',
          'message' => trans('unexpectedError'),
        ]);
      }
    } else {
      $rol->delete();
      return response()->json([
        'name' => 'Success',
        'state' => 'success',
        'message' => trans('roleDeleteOk'),
      ]);
    }
  }

  public function menuList()
  {
    $menuList[] = Menu::menus();
    return response()->json(['menuList' => $menuList]);
  }
}
