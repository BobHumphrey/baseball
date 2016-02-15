<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Batting;
use Grids;
use HTML;
use Illuminate\Support\Facades\Config;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\ColumnHeadersRow;
use Nayjest\Grids\Components\ColumnsHider;
use Nayjest\Grids\Components\CsvExport;
use Nayjest\Grids\Components\ExcelExport;
use Nayjest\Grids\Components\Filters\DateRangePicker;
use Nayjest\Grids\Components\FiltersRow;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\Laravel5\Pager;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\RenderFunc;
use Nayjest\Grids\Components\ShowingRecords;
use Nayjest\Grids\Components\TFoot;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\Components\TotalsRow;
use Nayjest\Grids\DbalDataProvider;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
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
