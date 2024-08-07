<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Services\HashidsService;

class User extends Authenticatable
{
  use HasApiTokens;
  use HasFactory;
  use HasProfilePhoto;
  use Notifiable;
  use TwoFactorAuthenticatable;
  use HasRoles;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = ['first_name','last_name', 'email','date_birth', 'password', 'contact', 'id_status'];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = ['id', 'password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret'];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  /**
   * The accessors to append to the model's array form.
   *
   * @var array<int, string>
   */
  protected $appends = ['encrypted_id', 'profile_photo_url'];

  protected $hashidsService;

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);

    // Inyectar HashidsService como una dependencia en el constructor
    $this->hashidsService = app(HashidsService::class);
  }

  public function getEncryptedIdAttribute()
  {
    // Usar $this->id en lugar de $this->attributes['id'] para acceder al ID del modelo
    return $this->hashidsService->encode($this->id);
  }
}
