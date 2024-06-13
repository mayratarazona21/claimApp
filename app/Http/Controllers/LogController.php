<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

class LogController extends Controller
{
  public function showLogAccess()
  {
    $logs = Log::orderBy('created_at', 'desc')
      ->where('action', 'access')
      ->leftJoin('users AS u', 'u.id', '=', 'logs.user_id')
      ->select('logs.id', 'logs.user_id', 'logs.details', 'logs.created_at', 'u.name as user')
      ->get();
    return view('administration.log.log-access', compact('logs'));
  }

  public function showLogActions()
  {
    $logs = Log::orderBy('created_at', 'desc')
      ->where('action', '!=', 'access')
      ->leftJoin('users AS u', 'u.id', '=', 'logs.user_id')
      ->select('logs.id', 'logs.user_id', 'logs.action', 'logs.details', 'logs.created_at', 'u.name as user')
      ->get();
    return view('administration.log.log-actions', compact('logs'));
  }

  public function show($id)
  {
    $log = Log::findOrFail($id);
    return view('administration.log.log-details', compact('log'));
  }
}
