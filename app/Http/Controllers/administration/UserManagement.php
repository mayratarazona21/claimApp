<?php

namespace App\Http\Controllers\administration;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Services\HashidsService;

class UserManagement extends Controller
{

  protected $hashidsService;

  public function __construct(HashidsService $hashidsService)
  {
    $this->hashidsService = $hashidsService;
  }
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

    return view('administration.user.index', [
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
      1 => 'encrypted_id',
      2 => 'first_name',
      3 => 'email',
      4 => 'email_verified_at',
      6 => 'contact',
      7 => 'id_status',
      8 => 'status',
      9 => 'roles',
      10 => 'date_birth'
    ];

    $search = [];

    $totalData = User::count();

    $totalFiltered = $totalData;

    $users = User::join('dictionary AS s', 's.id', '=', 'users.id_status')
    ->select('users.id','users.first_name','users.last_name','users.email','users.email_verified_at','users.contact','users.id_status','s.name as status','users.date_birth')
    ->get();

    foreach ($users as $user) {
      $nestedData['encrypted_id'] = $user->encrypted_id;
      $nestedData['first_name'] = $user->first_name;
      $nestedData['last_name'] = $user->last_name;
      $nestedData['date_birth'] = $user->date_birth;
      $nestedData['email'] = $user->email;
      $nestedData['email_verified_at'] = $user->email_verified_at;
      $nestedData['contact'] = $user->contact;
      $nestedData['id_status'] = $user->id_status;
      $nestedData['status'] = $user->status;
      $nestedData['roles'] = $user->getRoleNames();
      $data[] = $nestedData;
    }

    if (!empty($data)) {
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
    $user = new User();
    $roles = Role::where('id_status', 1)->get();
    $title = trans('createUser');
    $selectedRoles = [];
    return view('administration.user.user', compact('user', 'roles', 'title', 'selectedRoles'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

    //$id = $this->hashidsService->decode($request->UserId);
    $userID = $request->id;
    // create new one if email is unique
    $userEmail = User::where('email', $request->email)->first();

    if (empty($userEmail)) {
      $user = User::updateOrCreate(
        ['id' => $userID],
        [
          'first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'date_birth' => $request->date_birth,
          'email' => $request->email,
          'contact' => $request->contact,
          'password' => Hash::make($request->password),
        ]
      );

      $roles = Role::whereIn('id', $request->roles)->get()->pluck('name')->toArray();

      $user->syncRoles($roles);

      Log::create([
        'user_id' => auth()->id(),
        'action' => 'create',
        'details' => json_encode([
          'target_id' => $userID,
          'changes' => ['first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'email' => $request->email,
          'contact' => $request->contact,
          'date_birth' => $request->date_birth],
        ]),
      ]);
      return response()->json(['message' => trans('userCreateSuccessfully')]);
    } else {
      // user already exist
      return response()->json(['message' => trans('emailAlreadyExists')], 422);
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
  public function edit($encrypted_id)
  {
    $id = $this->hashidsService->decode($encrypted_id);

    $user = User::where('id' , $id)->first();
    $roles = Role::where('id_status', 1)->get();
    $selectedRoles = $user->roles()->pluck('id')->toArray();
    $title = trans('editUser');
    return view('administration.user.user', compact('user', 'roles', 'title','selectedRoles'));

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
    $userID = $this->hashidsService->decode($encrypted_id);
    $dataUpdate = ['first_name' => $request->first_name, 'last_name' => $request->last_name, 'date_birth' => $request->date_birth , 'email' => $request->email, 'contact' => $request->contact];

    $user = User::updateOrCreate(['id' => $userID], $dataUpdate );

   if(!empty($request->password)){
      $user = User::updateOrCreate(
        ['id' => $userID],
        ['password' => Hash::make($request->password)]
      );
      $dataUpdate['password'] = '******';
    }

    $user->roles()->sync($request->roles);

    Log::create([
      'user_id' => auth()->id(),
      'action' => 'update',
      'details' => json_encode([
        'target_id' => $userID,
        'changes' => $dataUpdate,
      ]),
    ]);

    // user updated
    return response()->json(['message' => trans('userUpdatedSuccessfully')]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($encrypted_id)
  {
    $id = $this->hashidsService->decode($encrypted_id);
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
