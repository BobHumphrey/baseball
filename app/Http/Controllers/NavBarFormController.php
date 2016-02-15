<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class NavBarFormController extends Controller {
  
  public function standings(Request $request) {
    $year = $request->input('year');
    $player = $request->input('player');
    if ($year) {
      return redirect('teams/standings/' . $year);
    }
    elseif ($player) {
      return redirect ('players/list/' . $player);
    }
    else {
      flashMessage("Error.", "alert-danger");
      return back();
    }
      
  }



}
