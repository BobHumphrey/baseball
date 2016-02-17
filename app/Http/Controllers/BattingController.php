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


class BattingController extends Controller {

  public static function team($teamID, $yearID) {
    $batters = Batting::leftJoin('master', 'batting.playerID', '=', 'master.playerID')
        ->select('master.nameLast', 'master.nameFirst', 'batting.playerID',
            'batting.G', 'batting.AB', 'batting.R', 'batting.H', 'batting.HR', 'batting.RBI')
        ->where('teamID', '=', $teamID)
        ->where('yearID', '=', $yearID);
    $grids = BattingController::grids($batters, 'team');
    return $grids;
  }

  public static function player($playerID) {
    $batters = Batting::leftJoin('master', 'batting.playerID', '=', 'master.playerID')
        ->leftJoin('teams', function($join) {
            $join->on('batting.teamID', '=', 'teams.teamID');
            $join->on('batting.yearID', '=', 'teams.yearID');
        })
        ->select('master.nameLast', 'master.nameFirst', 'teams.name', 'teams.yearID', 'teams.teamID',
            'batting.G', 'batting.AB', 'batting.R', 'batting.H', 'batting.HR', 'batting.RBI')
        ->where('batting.playerID', '=', $playerID);
    $grids = BattingController::grids($batters, 'player');
    return $grids;
  }

  public static function grids($batters, $page) {
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
      (new FieldConfig('average'))
        ->setLabel('AVG'),
      (new FieldConfig('G'))
        ->setLabel('G')
        ->setSortable(true),
      (new FieldConfig('AB'))
        ->setLabel('AB')
        ->setSortable(true),
      (new FieldConfig('R'))
        ->setLabel('R')
        ->setSortable(true),
      (new FieldConfig('H'))
        ->setLabel('H')
        ->setSortable(true),
    ];

    $additionalColumns = [
      (new FieldConfig('HR'))
        ->setLabel('HR')
        ->setSortable(true),
      (new FieldConfig('RBI'))
        ->setLabel('RBI')
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
            ($batters)
            )
        )
        ->setColumns($narrowGridColumns)
        ->setPageSize(500);
    $narrowGrid = new Grid($narrowCfg);

    $gridCfg = (new GridConfig())->setDataProvider(
            new EloquentDataProvider(
            ($batters)
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
