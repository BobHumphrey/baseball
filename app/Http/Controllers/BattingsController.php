<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Batting;
use Grids;
use HTML;
// Grids
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\EloquentDataRow;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;

class BattingsController extends Controller {

  public static function team($teamID, $yearID) {
    $batters = Batting::leftJoin('master', 'batting.playerID', '=', 'master.playerID')
        ->where('teamID', '=', $teamID)
        ->where('yearID', '=', $yearID);
//    \Debugbar::info($batters);
    $grids = BattingsController::grids($batters, 'team');
    return $grids;
  }

  public static function grids($batters, $page) {
     if ($page == 'team') {
      $idColumns = [
            (new FieldConfig)
            ->setName('nameLast')
            ->setLabel('Last'),
      ];
    }

    switch ($page) {
      case "team":
        \Log::info('page');
//        $gridColumns = $idColumns;
//        $narrowGridColumns = $idColumns;
        break;
    }

    $narrowCfg = (new GridConfig())->setDataProvider(
        new EloquentDataProvider(
            ($batters)
            )
        )
        ->setColumns($idColumns)
        ->setPageSize(500);
    $narrowGrid = new Grid($narrowCfg);

    $gridCfg = (new GridConfig())->setDataProvider(
            new EloquentDataProvider(
            ($batters)
            )
        )
        ->setColumns($idColumns)
        ->setPageSize(500);
    $grid = new Grid($gridCfg);

    return array(
      'narrowGrid' => $narrowGrid,
      'grid' => $grid,
    );
  }

}
