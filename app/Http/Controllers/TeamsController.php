<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Team;
use App\Franchise;

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
use Nayjest\Grids\EloquentDataRow;

class TeamsController extends Controller {

  public function year(Request $request) {
    $year = $request->input('year');
    return redirect('teams/standings/' . $year);
  }

  public function standings($year) {
    $teams = Team::leftJoin('league', 'lgID', '=', 'league.id')
        ->leftJoin('division', 'divID', '=', 'division.id')
        ->orderBy('lgID', 'asc')
        ->orderBy('sequence', 'asc')
        ->orderBy('Rank', 'asc')
        ->where('yearID', '=', $year)
        ->get();
    return view('teams.standings')->with([
          'teams' => $teams,
          'year' => $year,
    ]);
  }

  public static function showStandings($year) {
    $teams = Team::leftJoin('league', 'lgID', '=', 'league.id')
        ->leftJoin('division', 'divID', '=', 'division.id')
        ->orderBy('lgID', 'asc')
        ->orderBy('sequence', 'asc')
        ->orderBy('Rank', 'asc')
        ->where('yearID', '=', $year)
        ->get();
    return view('teams.standings')->with([
          'teams' => $teams,
          'year' => $year,
    ]);
  }

  public function show($teamID, $year) {
    $team = Team::leftJoin('league', 'lgID', '=', 'league.id')
        ->leftJoin('division', 'divID', '=', 'division.id')
        ->where('teamID', '=', $teamID)
        ->where('yearID', '=', $year)
        ->first();
    $battingGrids = BattingController::team($teamID, $year);
    $pitchingGrids = PitchingController::team($teamID, $year);
    $fieldingGrids = FieldingController::team($teamID, $year);
    return view('teams.show')->with([
          'team' => $team,
          'year' => $year,
          'battingGrids' => $battingGrids,
          'pitchingGrids' => $pitchingGrids,
          'fieldingGrids' => $fieldingGrids,
    ]);
  }

  public function franchise($franchiseID) {
    $teams = Team::where('franchID', '=', $franchiseID)
        ->take(999);
    $franchise = Franchise::where('franchID', '=', $franchiseID)
        ->first();
    $grids = TeamsController::grids($teams);
    return view('teams.franchise')->with([
          'name' => $franchise->franchName,
          'narrowGrid' => $grids['narrowGrid'],
          'grid' => $grids['grid'],
    ]);
  }

  public static function grids($teams) {
    $statColumns = [
        (new FieldConfig('yearID'))
            ->setLabel('Year')
            ->setSortable(true)
            ->setSorting(Grid::SORT_DESC)
            ->setCallback(function ($val) {
                  $hrefShow = action('TeamsController@standings', [$val]);
                  return '<a href="' . $hrefShow . '">' . $val . '</a>';
                }),
        (new FieldConfig('teamID'))
            ->setLabel('Name')
            ->setSortable(true)
            ->setCallback(function ($val, EloquentDataRow $row) {
              $rowData = $row->getSrc();
              $hrefShow = action('TeamsController@show', [$rowData->teamID, $rowData->yearID]);
              return '<a href="' . $hrefShow . '">' . $rowData->name . '</a>';
            }),
      (new FieldConfig('lgID'))
        ->setLabel('League')
        ->setSortable(true),
      (new FieldConfig('divID'))
        ->setLabel('Div')
        ->setSortable(true),
      (new FieldConfig('Rank'))
        ->setLabel('Rank')
        ->setSortable(true),
      (new FieldConfig('W'))
        ->setLabel('W')
        ->setSortable(true),
      (new FieldConfig('L'))
        ->setLabel('L')
        ->setSortable(true),
    ];

    $additionalColumns = [
      (new FieldConfig('attendance'))
        ->setLabel('Attendance')
        ->setSortable(true),
    ];

    $gridColumns = array_merge($statColumns, $additionalColumns);
    $narrowGridColumns = array_merge($statColumns);

   $narrowCfg = (new GridConfig())->setDataProvider(
        new EloquentDataProvider(
            ($teams)
            )
        )
        ->setPageSize(500)
        ->setColumns($narrowGridColumns);
    $narrowGrid = new Grid($narrowCfg);

    $gridCfg = (new GridConfig())->setDataProvider(
            new EloquentDataProvider(
            ($teams)
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
