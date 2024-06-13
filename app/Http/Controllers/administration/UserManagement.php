<?php

namespace App\Http\Controllers\administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserManagement extends Controller
{
  /**
   * Redirect to user-management view.
   *
   */
  public function UserManagement()
  {
    $users = User::all();
    $userCount = $users->count();
    $verified = User::whereNotNull('email_verified_at')
      ->get()
      ->count();
    $notVerified = User::whereNull('email_verified_at')
      ->get()
      ->count();
    $usersUnique = $users->unique(['email']);
    $userDuplicates = $users->diff($usersUnique)->count();
    $roles = Role::where('id_status', 1)->get();

    return view('administration.user.user-management', [
      'totalUser' => $userCount,
      'verified' => $verified,
      'notVerified' => $notVerified,
      'userDuplicates' => $userDuplicates,
      'roles' => $roles,
    ]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $columns = [
      1 => 'id',
      2 => 'name',
      3 => 'email',
      4 => 'email_verified_at',
      6 => 'contact',
      6 => 'status',
      7 => 'role',
    ];

    $search = [];

    $totalData = User::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $users = User::join('dictionary AS s', 's.id', '=', 'users.id_status')
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->select(
          'users.id',
          'users.name',
          'users.email',
          'users.email_verified_at',
          'users.contact',
          's.name as status'
        )
        ->get();
    } else {
      $search = $request->input('search.value');

      $users = User::where('users.id', 'LIKE', "%{$search}%")
        ->join('dictionary AS s', 's.id', '=', 'users.id_status')
        ->orWhere('users.name', 'LIKE', "%{$search}%")
        ->orWhere('users.email', 'LIKE', "%{$search}%")
        ->orWhere('r.name', 'LIKE', "%{$search}%")
        ->orWhere('s.name', 'LIKE', "%{$search}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->select(
          'users.id',
          'users.name',
          'users.email',
          'users.email_verified_at',
          'users.contact',
          's.name as status'
        )
        ->get();

      $totalFiltered = User::where('users.id', 'LIKE', "%{$search}%")
        ->join('dictionary AS s', 's.id', '=', 'users.id_status')
        ->orWhere('users.name', 'LIKE', "%{$search}%")
        ->orWhere('users.email', 'LIKE', "%{$search}%")
        ->orWhere('r.name', 'LIKE', "%{$search}%")
        ->orWhere('s.name', 'LIKE', "%{$search}%")
        ->select('users.id')
        ->count();
    }

    $data = [];

    if (!empty($users)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($users as $user) {
        $nestedData['id'] = $user->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['name'] = $user->name;
        $nestedData['email'] = $user->email;
        $nestedData['email_verified_at'] = $user->email_verified_at;
        $nestedData['contact'] = $user->contact;
        $nestedData['status'] = $user->status;
        $nestedData['role'] = $user->roles()->first() ? ucfirst($user->roles()->first()->name) : '';
        $data[] = $nestedData;
      }
    }

    if ($data) {
      return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => intval($totalData),
        'recordsFiltered' => intval($totalFiltered),
        'code' => 200,
        'data' => $data,
      ]);
    } else {
      return response()->json([
        'message' => 'Internal Server Error',
        'code' => 500,
        'data' => [],
      ]);
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $userID = $request->id;

    if ($userID) {
      // update the value
      $user = User::updateOrCreate(
        ['id' => $userID],
        ['name' => $request->name, 'email' => $request->email, 'contact' => $request->contact]
      );

      $oldRole = $user->roles()->first();
      $newRole = Role::find($request->idRole);
      $user->roles()->sync([$newRole->id]);

      if ($oldRole) {
        $user->roles()->detach($oldRole);
      }

      Log::create([
        'user_id' => auth()->id(),
        'action' => 'update',
        'details' => json_encode([
          'target_id' => $id,
          'changes' => $request->all(),
        ]),
      ]);

      // user updated
      return response()->json('Updated');
    } else {
      // create new one if email is unique
      $userEmail = User::where('email', $request->email)->first();

      if (empty($userEmail)) {
        $user = User::updateOrCreate(
          ['id' => $userID],
          [
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'password' => bcrypt(Str::random(10)),
          ]
        );

        $role = Role::find($request->idRole);
        $user->roles()->attach($role);

        Log::create([
          'user_id' => auth()->id(),
          'action' => 'update',
          'details' => json_encode([
            'target_id' => $id,
            'changes' => $request->all(),
          ]),
        ]);

        // user created
        return response()->json('Created');
      } else {
        // user already exist
        return response()->json(['message' => 'already exits'], 422);
      }
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $where = ['id' => $id];

    $users = User::where($where)->first();

    return response()->json($users);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //$users = User::where('id', $id)->delete();
    Log::create([
      'user_id' => auth()->id(),
      'action' => 'delete',
      'details' => json_encode([
        'target_id' => $id,
      ]),
    ]);
    $users = User::updateOrCreate(['id' => $id], ['id_status' => 2]);
  }
}
