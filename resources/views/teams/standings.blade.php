<?php
$previousLgID = '';
$previousDivID = '';
$firstTeam = true;
$leaderW = 0;
$leaderL = 0;
?>

@extends('app')

@section('pageTitle')

{{$year}} Standings

@stop

@section('content')

@foreach ($teams as $team)
@if(($team->lgID != $previousLgID) || ($team->divID != $previousDivID))
@if (!$firstTeam)
</table>
@endif
@if($team->lgID != $previousLgID)
<h3>{{$team->leagueName}}</h3>
@endif
<?php
$leaderW = $team->W;
$leaderL = $team->L;
?>
<table class="table table-striped">
  <tr>
    <th class="standings-team">{{$team->divisionName}}</th>
    <th class="standings-w">W</th>
    <th class="standings-l">L</th>
    <th class="standings-pct">PCT</th>
    <th class="standings-gb">GB</th>
  </tr>
  @endif
  <?php
  $pct = $team->W / ($team->W + $team->L);
  $displayPct = substr(number_format($pct, 3), 1);
  $GB = (($leaderW - $team->W) + ($team->L - $leaderL)) / 2;
  $firstTeam = false;
  $previousLgID = $team->lgID;
  $previousDivID = $team->divID;
  $url = action('TeamsController@show', ['team' => $team->teamID, 'year' => $team->yearID]);
  ?>
  <tr>
    <td class="standings-team"><a href="{{$url}}">{{$team->name}}</a></td>
    <td class="standings-w">{{$team->W}}</td>
    <td class="standings-l">{{$team->L}}</td>
    <td class="standings-pct">{{$displayPct}}</td>
    <td class="standings-gb">{{$GB}}</td>
  </tr>
  @endforeach
</table>
@stop
