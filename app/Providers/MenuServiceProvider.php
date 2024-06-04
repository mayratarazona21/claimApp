<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Menu;
use App\Models\Submenu;
use \stdClass;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    $verticalMenuData = new \stdClass();
    $verticalMenuData->menu = [];

    $verticalMenuData->menu = Menu::menus();

    //$verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenu.json'));
    //$verticalMenuData = json_decode($verticalMenuJson);
    //dd($verticalMenuData);
    $horizontalMenuJson = file_get_contents(base_path('resources/menu/horizontalMenu.json'));
    $horizontalMenuData = json_decode($horizontalMenuJson);

    // Share all menuData to all the views
    \View::share('menuData', [$verticalMenuData, $horizontalMenuData]);
  }
}
