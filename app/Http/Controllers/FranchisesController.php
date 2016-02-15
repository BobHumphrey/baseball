<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Franchise;

class FranchisesController extends Controller {

  public function index() {
    $franchises = Franchise::orderBy('franchName', 'asc')
        ->get();
    $records = threeColumns($franchises);
    return view('franchises.index')->with([
          'recordsCol1' => $records['recordsCol1'],
          'recordsCol2' => $records['recordsCol2'],
          'recordsCol3' => $records['recordsCol3'],
    ]);
  }


}
