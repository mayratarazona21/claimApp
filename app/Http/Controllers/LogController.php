<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

class LogController extends Controller
{
  public function showLogAccess()
  {


    $logs = Log::orderBy('created_at', 'desc')
      ->where('action_id', 3)
      ->leftJoin('users AS u', 'u.id', '=', 'logs.user_id')
      ->select('logs.id', 'logs.user_id', 'logs.description', 'logs.created_at', 'u.first_name' , 'u.last_name')
      ->get();

      Log::accessListLog(Auth()->user()->id, 'logs');

    return view('administration.log.log-access', compact('logs'));
  }

  public function showLogActions()
  {
    $logs = Log::orderBy('created_at', 'desc')
      ->where('action_id', '!=', 3)
      ->join('dictionary AS action', 'action.id', '=', 'logs.action_id')
      ->leftJoin('users AS u', 'u.id', '=', 'logs.user_id')
      ->select('logs.id', 'logs.user_id', 'logs.action_id','action.name as action', 'logs.description', 'logs.created_at', 'u.first_name' , 'u.last_name')
      ->get();
    return view('administration.log.log-actions', compact('logs'));
  }

  public function show($id)
  {
    $log = Log::where('logs.id', $id)
    ->join('dictionary AS action', 'action.id', '=', 'logs.action_id')
    ->leftJoin('users AS u', 'u.id', '=', 'logs.user_id')
    ->select('logs.id', 'logs.user_id', 'action.name as action', 'logs.description','logs.details', 'logs.created_at', 'u.first_name' , 'u.last_name')
    ->first(); //dd($log);

    return view('administration.log.log-details', compact('log'));
  }
}
