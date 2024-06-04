<?php

namespace App\Services;

use Hashids\Hashids;

class HashidsService
{
  protected $hashids;

  public function __construct()
  {
    // Obtener la configuración de Hashids desde el archivo de configuración
    $config = config('hashids.connections.main');

    // Crear una instancia de Hashids con la configuración
    $this->hashids = new Hashids($config['salt'], $config['length']);
  }

  public function encode($id)
  {
    // Encriptar el ID
    return $this->hashids->encode($id);
  }

  public function decode($hash)
  {
    // Desencriptar el hash
    return $this->hashids->decode($hash);
  }
}
