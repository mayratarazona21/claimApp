<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
  use HasFactory;

  protected $fillable = ['user_id', 'action_id', 'target_id', 'target_table', 'description', 'details'];

  public static function accessListLog(int $user_id, string $target_table){
		Log::create([
    		'user_id' => $user_id,
    		'action_id' => 3,
    		'description' => trans('log.'.$target_table.'.accessList')
    	]);
	}

  public static function accessLog(int $user_id, int $target_id, string $target_table, array $aDetails){
		Log::create([
    		'user_id' => $user_id,
    		'action_id' => 3,
        'target_id' => $target_id,
        'target_table' => $target_table,
    		'description' => trans('log.'.$target_table.'.access', $aDetails)
    	]);
	}

  public static function createLog(int $user_id, string $target_table, int $target_id, array $aDetails){
    Log::create([
      'user_id' => $user_id,
    	'action_id' => 4,
      'target_id' => $target_id,
      'target_table' => $target_table,
      'description' => trans('log.'.$target_table.'.create', $aDetails),
      'details' => json_encode($aDetails)
    ]);
  }

  public static function updateLog(int $user_id, string $target_table, int $target_id, array $aDetails, array $aChanges){

		Log::create([
      'user_id' => $user_id,
    	'action_id' => 5,
      'target_id' => $target_id,
      'target_table' => $target_table,
      'description' => trans('log.'.$target_table.'.update', $aDetails),
      'details' => json_encode($aChanges)
    ]);
	}

  public static function deleteLog(int $user_id, string $target_table, int $target_id, array $aDetails){
		Log::create([
    		'user_id' => $user_id,
    		'action_id' => 6,
    		'target_table' => $target_table,
    		'target_id' => $target_id,
    		'description' => trans('Log.'.$target_table.'.delete', $aDetails)
    	]);
	}

}
