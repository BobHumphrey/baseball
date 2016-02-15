<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Master;
use App\Team;
use App\Batting;
use App\Pitching;
use App\Fielding;

class PlayersController extends Controller {

  public function show($playerID) {
    $player = Master::where('playerID', '=', $playerID)
        ->first();
    $battingGrids = BattingController::player($playerID);
    $pitchingGrids = PitchingController::player($playerID);
    $fieldingGrids = FieldingController::player($playerID);
    return view('players.show')->with([
          'player' => $player,
          'battingGrids' => $battingGrids,
          'pitchingGrids' => $pitchingGrids,
          'fieldingGrids' => $fieldingGrids,
    ]);
  }

  public function playersList($name) {
    $players = Master::where('nameLast', 'like', $name . '%')
        ->orderBy('nameLast', 'asc')
        ->orderBy('nameFirst', 'asc')
        ->get();
    $records = threeColumns($players);
    return view('players.list')->with([
          'name' => strtoupper($name),
          'recordsCol1' => $records['recordsCol1'],
          'recordsCol2' => $records['recordsCol2'],
          'recordsCol3' => $records['recordsCol3'],
    ]);
  }

}
