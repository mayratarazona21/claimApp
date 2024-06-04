<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use App\Services\HashidsService;

class CustomRole extends SpatieRole
{
  protected $appends = ['encrypted_id'];
  protected $hidden = ['id'];

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
