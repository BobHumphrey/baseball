<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Fielding;
// Grids
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\EloquentDataRow;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;


class FieldingController extends Controller {

  public static function team($teamID, $yearID) {
    $fielders = Fielding::leftJoin('master', 'fielding.playerID', '=', 'master.playerID')
        ->select('master.nameLast', 'master.nameFirst', 'fielding.playerID',
            'fielding.POS', 'fielding.G', 'fielding.GS', 'fielding.PO', 'fielding.A', 'fielding.E', 'fielding.DP')
        ->where('teamID', '=', $teamID)
        ->where('yearID', '=', $yearID);
    $grids = FieldingController::grids($fielders, 'team');
    return $grids;
  }

  public static function player($playerID) {
    $fielders = Fielding::leftJoin('master', 'fielding.playerID', '=', 'master.playerID')
        ->leftJoin('teams', function($join) {
            $join->on('fielding.teamID', '=', 'teams.teamID');
            $join->on('fielding.yearID', '=', 'teams.yearID');
        })
        ->select('master.nameLast', 'master.nameFirst', 'teams.name', 'teams.yearID', 'teams.teamID',
            'fielding.POS', 'fielding.G', 'fielding.GS', 'fielding.PO', 'fielding.A', 'fielding.E', 'fielding.DP')
        ->where('fielding.playerID', '=', $playerID);
    $grids = FieldingController::grids($fielders, 'player');
    return $grids;
  }

  public static function grids($fielders, $page) {
     if ($page == 'team') {
      $nameColumns = [
        (new FieldConfig('playerID'))
            ->setLabel('Name')
            ->setSortable(true)
            ->setCallback(function ($val, EloquentDataRow $row) {
              $rowData = $row->getSrc();
              $playerName = $rowData->nameLast . ', ' . $rowData->nameFirst;
              $hrefShow  = action('PlayersController@show', [$val]);
              return '<a href="' . $hrefShow . '">' . $rowData->nameLast . ', ' . $rowData->nameFirst . '</a>';
            }),

      ];
    }
    elseif ($page == 'player') {
      $teamColumns = [
        (new FieldConfig('yearID'))
           ->setLabel('Year')
           ->setSortable(true)
           ->setSorting(Grid::SORT_DESC)
           ->setCallback(function ($val) {
             $hrefShow  = action('TeamsController@standings', [$val]);
             return '<a href="' . $hrefShow . '">' . $val . '</a>';
           }),
        (new FieldConfig('teamID'))
            ->setLabel('Name')
            ->setSortable(true)
            ->setCallback(function ($val, EloquentDataRow $row) {
              $rowData = $row->getSrc();
              $hrefShow  = action('TeamsController@show', [$rowData->teamID, $rowData->yearID]);
              return '<a href="' . $hrefShow . '">' . $rowData->name . '</a>';
            }),
      ];
    }

    $statColumns = [
      (new FieldConfig('POS'))
        ->setLabel('POS')
        ->setSortable(true),
      (new FieldConfig('G'))
        ->setLabel('G')
        ->setSortable(true),
      (new FieldConfig('GS'))
        ->setLabel('GS')
        ->setSortable(true),
      (new FieldConfig('PO'))
        ->setLabel('PO')
        ->setSortable(true),
      (new FieldConfig('A'))
        ->setLabel('A')
        ->setSortable(true),
    ];

    $additionalColumns = [
      (new FieldConfig('E'))
        ->setLabel('E')
        ->setSortable(true),
      (new FieldConfig('DP'))
        ->setLabel('DP')
        ->setSortable(true),
    ];

    switch ($page) {
      case "team":
        $gridColumns = array_merge($nameColumns, $statColumns, $additionalColumns);
        $narrowGridColumns = array_merge($nameColumns, $statColumns);
        break;
      case "player":
        $gridColumns = array_merge($teamColumns, $statColumns, $additionalColumns);
        $narrowGridColumns = array_merge($teamColumns, $statColumns);
        break;
    }

    $narrowCfg = (new GridConfig())->setDataProvider(
        new EloquentDataProvider(
            ($fielders)
            )
        )
        ->setColumns($narrowGridColumns)
        ->setPageSize(500);
    $narrowGrid = new Grid($narrowCfg);

    $gridCfg = (new GridConfig())->setDataProvider(
            new EloquentDataProvider(
            ($fielders)
            )
        )
        ->setColumns($gridColumns)
        ->setPageSize(500);
    $grid = new Grid($gridCfg);

    return array(
      'narrowGrid' => $narrowGrid,
      'grid' => $grid,
    );
  }

}
