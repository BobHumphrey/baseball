<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pitching;
// Grids
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\EloquentDataRow;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;


class PitchingController extends Controller {

  public static function team($teamID, $yearID) {
    $pitchers = Pitching::leftJoin('master', 'pitching.playerID', '=', 'master.playerID')
        ->select('master.nameLast', 'master.nameFirst', 'pitching.playerID',
            'pitching.G', 'pitching.W', 'pitching.L', 'pitching.SV', 'pitching.ERA',
            'pitching.SO', 'pitching.BB')
        ->where('teamID', '=', $teamID)
        ->where('yearID', '=', $yearID);
    $grids = PitchingController::grids($pitchers, 'team');
    return $grids;
  }

  public static function player($playerID) {
    $pitchers = Pitching::leftJoin('master', 'pitching.playerID', '=', 'master.playerID')
        ->leftJoin('teams', function($join) {
            $join->on('pitching.teamID', '=', 'teams.teamID');
            $join->on('pitching.yearID', '=', 'teams.yearID');
        })
        ->select('master.nameLast', 'master.nameFirst', 'teams.name', 'teams.yearID',
            'teams.teamID', 'pitching.ERA', 'pitching.G', 'pitching.W', 'pitching.L',
            'pitching.SV', 'pitching.SO', 'pitching.BB')
        ->where('pitching.playerID', '=', $playerID);
    $grids = PitchingController::grids($pitchers, 'player');
    $count = $pitchers->count();
    $grids['count'] = $count;
    return $grids;
  }

  public static function grids($pitchers, $page) {
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
      (new FieldConfig('ERA'))
        ->setLabel('ERA')
        ->setSortable(true),
      (new FieldConfig('G'))
        ->setLabel('G')
        ->setSortable(true),
      (new FieldConfig('W'))
        ->setLabel('W')
        ->setSortable(true),
      (new FieldConfig('L'))
        ->setLabel('L')
        ->setSortable(true),
      (new FieldConfig('SV'))
        ->setLabel('SV')
        ->setSortable(true),
    ];

    $additionalColumns = [
      (new FieldConfig('SO'))
        ->setLabel('SO')
        ->setSortable(true),
      (new FieldConfig('BB'))
        ->setLabel('BB')
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
            ($pitchers)
            )
        )
        ->setColumns($narrowGridColumns)
        ->setPageSize(500);
    $narrowGrid = new Grid($narrowCfg);

    $gridCfg = (new GridConfig())->setDataProvider(
            new EloquentDataProvider(
            ($pitchers)
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
