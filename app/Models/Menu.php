<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
  public function getChildren($data, $line)
  {
    $children = [];

    foreach ($data as $line1) {
      if ($line->id == $line1->parent) {
        $submenus = $this->getChildren($data, $line1);
        if (count($submenus) > 0) {
          $line1->submenu = $submenus;
        }
        $children[] = $line1;
      }
    }

    return $children;
  }

  public function optionsMenu()
  {
    return $this->where('enabled', 1)
      ->orderby('parent')
      ->orderby('order')
      ->orderby('name')
      ->get();
  }

  public static function menus()
  {
    $menus = new Menu();
    $data = $menus->optionsMenu();
    $menuAll = [];
    foreach ($data as $line) {
      $submenus = $menus->getChildren($data, $line);

      if (count($submenus) > 0) {
        $line->submenu = $submenus;
      }

      if ($line->parent == 0) {
        $menuAll[] = $line;
      }
    }
    return $menus->menuAll = $menuAll;
  }
}
